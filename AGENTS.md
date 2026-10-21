# Repository guide for coding agents

Read `DEPLOYMENT.md` before changing content, deployment files, or backup
configuration.

## Sources of truth

- Git is the source of truth for application code, templates, configuration,
  and theme assets.
- Staging is the source of truth for Kirby content and Panel-managed settings.
- Backblaze B2 stores nightly backups of staging content and accounts.
- Production receives approved content from staging through the Panel publishing
  plugin.

The `content/` directory is intentionally excluded from Git. Do not treat a
local content copy as authoritative.

## Working rules

- Preserve unrelated changes in the working tree.
- Do not send any change to production before it exists and is verified on
  staging.
- Make normal content changes through the staging Panel.
- Run `./devops.sh sync-stg` before local work that depends on current content.
- Use `./devops.sh push-stg` when a development session creates content locally.
- Do not copy content into staging by hand. The script provides backup,
  validation, rollback, and CSS regeneration.
- Test application changes locally, then on staging, before production.
- Do not recreate remote services casually. The remote host uses Docker 19.03
  and API 1.40, which is incompatible with some current Compose operations.

## Generated custom CSS

The Panel stores custom CSS in the `Customcss` field of
`content/site.en.txt`. Kirby and the container startup process generate
`public/assets/css/site.css` from that field.

Do not edit or commit `site.css` directly.

## Current work

Read `HOMEPAGE_REFRESH.md` for the active homepage roadmap, decisions, and
status. Update it when a decision is made or a task changes state. Do not mark
an item complete until it has been verified on staging.

