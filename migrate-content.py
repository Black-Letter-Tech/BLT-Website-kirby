#!/usr/bin/env python3
"""Transform Kirby 3 plugin field storage to Kirby 4/5 native shapes.

k3-image-clip stored file references as objects with an id key. Native
files fields store plain filename lists. This rewrites both storage
styles in place across a content directory:

  JSON (blocks/layouts):  "image": [{"id":"x.png"}]  ->  "image": ["x.png"]
  YAML (plain fields):    - \n  id: x.png            ->  - x.png

hananils/kirby-colors accepted any CSS color string; the core color
field in hex format validates hex only. rgb()/rgba() values become
8-digit hex, which is also valid CSS wherever the value is echoed:

  rgba(0,0,0,0.3)  ->  #0000004d

Run it against a content directory, dry-run by default:

  python3 migrate-content.py content          # report only
  python3 migrate-content.py content --write  # apply
"""

import re
import sys
from pathlib import Path

JSON_PAT = re.compile(r'\[\{"id":"([^"]+)"\}\]')
# the same shape escaped inside a JSON string (blocks nested in layouts)
JSON_ESC_PAT = re.compile(r'\[\{\\"id\\":\\"([^"\\]+)\\"\}\]')
YAML_PAT = re.compile(r'^(\s*)- ?\n\s+id: (\S+)$', re.M)
RGBA_PAT = re.compile(r'rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*([\d.]+)\s*)?\)')


def rgba_to_hex(m: re.Match) -> str:
    r, g, b = (min(int(m.group(i)), 255) for i in (1, 2, 3))
    out = f"#{r:02x}{g:02x}{b:02x}"
    if m.group(4) is not None:
        a = min(round(float(m.group(4)) * 255), 255)
        if a < 255:
            out += f"{a:02x}"
    return out


def transform(text: str) -> tuple[str, int]:
    count = 0

    def json_sub(m):
        nonlocal count
        count += 1
        return '["' + m.group(1) + '"]'

    def yaml_sub(m):
        nonlocal count
        count += 1
        return f"{m.group(1)}- {m.group(2)}"

    def rgba_sub(m):
        nonlocal count
        count += 1
        return rgba_to_hex(m)

    def json_esc_sub(m):
        nonlocal count
        count += 1
        return '[\\"' + m.group(1) + '\\"]'

    text = JSON_PAT.sub(json_sub, text)
    text = JSON_ESC_PAT.sub(json_esc_sub, text)
    text = YAML_PAT.sub(yaml_sub, text)
    text = RGBA_PAT.sub(rgba_sub, text)
    return text, count


def main():
    if len(sys.argv) < 2:
        sys.exit(__doc__)
    root = Path(sys.argv[1])
    write = "--write" in sys.argv
    total = 0
    for f in sorted(root.rglob("*.txt")):
        text = f.read_text(errors="ignore")
        new, count = transform(text)
        if count:
            total += count
            print(f"{count:3}  {f}")
            if write:
                f.write_text(new)
    print(f"{'applied' if write else 'found'}: {total} field values")


if __name__ == "__main__":
    main()
