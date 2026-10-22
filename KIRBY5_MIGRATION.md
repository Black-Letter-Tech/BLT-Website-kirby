# Kirby 5 migration

Branch `kirby5`, worked in the `blt-k5` worktree. Target: Kirby 5.6.x on
PHP 8.4. Trigger: CVE-2026-109618/109619 (PHP 8.1 receives no fix).

## Status

- [x] Image rebased on php:8.2-fpm-alpine (PHP 8.2.35, CVE patched)
- [x] Core upgraded to Kirby 4.9.6
- [x] commentions, kirby-sanitizer, k3-image-clip, kirby-colors,
      table-field removed
- [x] clip() calls rewritten to core resize(); toImage/toImages now
      alias toFile/toFiles in zero-one
- [x] colors fields swapped to the core color field
- [x] link-field and code-editor moved to composer (Kirby 4 releases)
- [ ] Panel walkthrough on Kirby 4 (fields, blocks, deploy button)
- [ ] Core upgrade to Kirby 5.6, bnomei plugins to 5.x
- [ ] Decide link-field on Kirby 5 (its release constraint stops at
      Kirby 4: vendor it if it works, replace with an object field
      if not)
- [ ] Rebuild the webhook deploy button as a Kirby 5 view button
- [ ] PHP bump to 8.4 in the Dockerfile
- [ ] Kirby license purchase (needed at launch, not for dev)

## Cutover checklist (staging, then production)

1. Fresh content sync, then re-apply content transforms:
   `python3 migrate-content.py content --write`
   (old image-clip file references and rgb()/rgba() color values;
   dry-run first without --write)
2. First boot migrates content (UUIDs are written). Take a manual
   B2-independent backup before it.
3. Re-test the "Deploy content to Production" button end to end.
4. Verify with `./devops.sh verify-stg`; check favicon markup and
   custom CSS generation.
5. Never run push-stg from this worktree before cutover: migrated
   content must not land on the Kirby 3 staging site.

## Notes

- Deleted comment test data lives in `_commentions/` folders in
  staging content; harmless, remove during cutover.
- autoresize is abandoned upstream but works; replace with a hook in
  zero-one if it breaks later.
- sitemapper and texnixe/similar are old but server-side; test and
  replace only on failure.
