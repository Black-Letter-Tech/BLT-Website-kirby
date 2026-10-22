#!/usr/bin/env python3
"""Compare the local migration sandbox against the live production site.

Walks every page in the local sitemap and reports, per page:

  - status code differences
  - visible text differences (tags stripped, whitespace collapsed)
  - image differences by filename (thumb dimensions kept; Kirby 4's
    "-crop" naming matched against Kirby 3's "-crop-true")
  - locally emitted asset URLs that do not return 200

Run it manually until it reports clean:

  python3 verify-vs-prod.py
  python3 verify-vs-prod.py --local http://localhost:8081 --prod https://blackletter.tech
"""

import argparse
import difflib
import html
import re
import sys
import urllib.request

UA = {"User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36"}
LOCAL_AUTH = None  # set from --auth for a basic-auth protected local/staging side


def fetch(url, timeout=30, auth=None):
    req = urllib.request.Request(url, headers=UA)
    if auth:
        import base64
        req.add_header("Authorization", "Basic " + base64.b64encode(auth.encode()).decode())
    try:
        r = urllib.request.urlopen(req, timeout=timeout)
        return r.status, r.read().decode(errors="ignore")
    except urllib.error.HTTPError as e:
        return e.code, ""
    except Exception as e:
        return str(e)[:50], ""


def cut_shuffled(page):
    """Drop everything from the related-articles slider on. Its picks are
    shuffled per render, so it never compares equal, even prod vs prod."""
    return re.split(r"<h4>[^<]*also like[^<]*</h4>", page)[0]


def visible_text(page):
    t = re.sub(r"<(script|style)[^>]*>.*?</\1>", " ", page, flags=re.S | re.I)
    t = re.sub(r"<[^>]+>", " ", t)
    return re.sub(r"\s+", " ", html.unescape(t)).strip()


def image_names(page):
    names = set()
    for m in re.finditer(r'media/(?:pages|site)/[^"\s,)\\>]+', page):
        name = m.group(0).split("/")[-1].split("?")[0]
        name = name.replace("-crop-true", "-crop")
        # Kirby 3 sanitized underscores and interior dots to hyphens in media
        # URLs; Kirby 4 keeps them. Same files, different spelling.
        stem, _, ext = name.rpartition(".")
        stem = re.sub("-+", "-", stem.replace("_", "-").replace(".", "-"))
        names.add(stem + "." + ext)
    return names


def asset_urls(page, base):
    urls = set()
    for m in re.finditer(r'(?:src|srcset|href|data-src(?:set)?|sources)="([^"]+)"', page):
        for part in html.unescape(m.group(1)).replace("srcset: ", "").split(","):
            u = part.strip().split(" ")[0]
            if "media/" in u or "/assets/" in u:
                if u.startswith("/"):
                    urls.add(base + u)
                elif u.startswith(base):
                    urls.add(u)
    return urls


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--local", default="http://localhost:8081")
    ap.add_argument("--prod", default="https://blackletter.tech")
    ap.add_argument("--auth", help="user:pass for the --local side (staging)")
    args = ap.parse_args()

    status, sitemap = fetch(args.local + "/sitemap.xml", auth=args.auth)
    if status != 200:
        sys.exit(f"local sitemap failed: {status}")
    paths = sorted(
        re.sub(r"https?://[^/]*", "", loc) or "/"
        for loc in re.findall(r"<loc>([^<]+)</loc>", sitemap)
    )

    problems = 0
    for p in paths:
        issues = []
        ls, lbody = fetch(args.local + p, auth=args.auth)
        ps, pbody = fetch(args.prod + p)
        if ls != ps:
            issues.append(f"status local={ls} prod={ps}")
        if ls == 200 and ps == 200:
            lbody, pbody = cut_shuffled(lbody), cut_shuffled(pbody)
            lt, pt = visible_text(lbody), visible_text(pbody)
            if lt != pt:
                d = list(difflib.unified_diff(pt.split(), lt.split(), lineterm="", n=2))
                issues.append("text differs: " + " ".join(d[5:17]))
            li, pi = image_names(lbody), image_names(pbody)
            if pi - li:
                issues.append(f"images missing locally: {sorted(pi - li)[:4]}")
            dead = []
            for u in sorted(asset_urls(lbody, args.local)):
                s, _ = fetch(u, auth=args.auth)
                if s != 200:
                    dead.append(f"{s} {u[len(args.local):][:80]}")
            if dead:
                issues.append("dead local assets: " + "; ".join(dead[:4]))
        if issues:
            problems += 1
            print(f"DIFF {p}")
            for i in issues:
                print(f"     {i}")
        else:
            print(f"OK   {p}")
    print(f"\n{len(paths)} pages, {problems} with differences")
    sys.exit(1 if problems else 0)


if __name__ == "__main__":
    main()
