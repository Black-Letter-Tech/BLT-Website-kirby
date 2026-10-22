# Development and deployment

This project separates application code from Kirby-managed content.

## Sources of truth

- Git stores application code, templates, configuration, and theme assets.
- Staging stores Kirby content and accounts in Docker volumes.
- Backblaze B2 stores nightly staging content and account backups.
- Production is a published copy of approved staging content.

The `content/` directory is intentionally ignored by Git. Treat staging as the
source of truth for content.

## Requirements

- Docker Desktop for local development
- A docker context (`blt-pub02`) over SSH for remote operations
- A project `.env` file
- SSH access to `blt-pub02` (key `SSH blt-pub02` in 1Password)

`SLD` means second-level domain. For this project, it resolves to
`blackletter`.

## Start a work session

Pull current staging content before local work that depends on content:

```sh
./devops.sh sync-stg
```

The command downloads and validates staging content before replacing the local
copy. It does not change staging.

## Local Docker

Build the local image:

```sh
set -o allexport
source .env
set +o allexport
unset DOCKER_CONTEXT
docker build -t "wagnerpaul/${SLD}-main-app:local" .
```

Run the site at `http://localhost:8080`:

```sh
docker run --rm -d \
  --name "${SLD}-local" \
  --volume "$(pwd):/app" \
  --publish 8080:80 \
  --env ENABLE_PANEL=true \
  "wagnerpaul/${SLD}-main-app:local"
```

Stop the local container:

```sh
docker stop "${SLD}-local"
```

The interactive `devops.sh` menu also provides local build and run commands.

## Content workflow

Use the staging Panel for normal page, layout, and site-setting changes.

1. Run `./devops.sh sync-stg` when local content context is required.
2. Make content changes in the staging Panel.
3. Review the staging site.
4. Publish approved staging content with the Panel publishing plugin.

Some development sessions also create content locally. Push that content with:

```sh
./devops.sh push-stg
```

This command performs these operations:

1. Validate the local content copy.
2. Create a fresh staging content backup.
3. Upload and validate the replacement content.
4. Stop staging during the replacement.
5. Restore the previous content if replacement fails.
6. Restart staging and regenerate custom CSS.

Do not copy content into the container manually. The scripted workflow adds
validation, backup, downtime control, and rollback.

Verify staging after a container restart or deployment:

```sh
./devops.sh verify-stg
```

The command removes the cached homepage, requests it through the public HTTPS
endpoint, and rejects HTTP media URLs. Do not prime the staging homepage cache
with an internal HTTP request. Kirby page caching stores absolute media URLs,
which causes browsers to block images as mixed content.

The staging host config also fixes Kirby's canonical URL to
`https://stg.blackletter.tech`. This prevents direct internal HTTP requests
from generating mixed-content URLs before the cache is populated.

## Custom CSS

The Panel field **Site > Styling > Custom CSS** is stored as `Customcss` in
`content/site.en.txt`.

Kirby writes that value to `public/assets/css/site.css` after a site-settings
save. The container also regenerates the file during every startup, after the
content volume is mounted.

`site.css` is generated and ignored by Git. Do not edit or commit it directly.
Edit the Panel field instead.

## Application workflow

Application changes flow in the opposite direction from content:

1. Change code locally on a feature branch.
2. Build and test the local image.
3. Push the branch to GitHub.
4. Build the staging image locally and ship it to the remote daemon.
5. Verify staging before promoting the image to production.

Never publish an untested application image directly to production.

## Building images for the remote host

The host (blt-pub02, Debian 13, current Docker) runs amd64. Build
locally for that platform and ship the result; the 2GB host serves
three sites and should not also compile extensions:

```sh
unset DOCKER_DEFAULT_PLATFORM
docker buildx build --platform linux/amd64 \
  -t "wagnerpaul/${SLD}-main-app:stg" --load .
docker save "wagnerpaul/${SLD}-main-app:stg" | ssh blt-pub02 docker load
```

Then recreate the staging container and re-inject the two files that
live in the container layer by design (images stay secret-free):

```sh
export DOCKER_CONTEXT=blt-pub02
docker compose up -d --force-recreate stg
docker cp ./.env "${SLD}-stg:app"
docker exec "${SLD}-stg" sh -c 'set -o allexport; . ./.env; set +o allexport; \
  htpasswd -c -B -b /etc/nginx/.htpasswd "$BASIC_AUTH_USER" "$BASIC_AUTH_PASSWORD"'
```

Any container recreation, by compose or otherwise, loses `.env` and
`.htpasswd`; always replay the injection step.

`DOCKER_DEFAULT_PLATFORM` must stay unset for compose and build
commands; it is set in the login shell and changes build targets.

## Remote Docker access

Load the project environment and select the remote Docker host:

```sh
set -o allexport
source .env
set +o allexport
export DOCKER_CONTEXT=blt-pub02
```

Open a staging shell:

```sh
docker exec -it "${SLD}-stg" /bin/sh
```

Open a production shell:

```sh
docker exec -it "${SLD}-prod" /bin/sh
```

Staging and production share the Compose project and proxy network.

## Backups

Volumerize backs up these staging volumes to Backblaze B2:

- `${SLD}-stg-content`
- `${SLD}-accounts`

Jobs run daily at 04:00 UTC. A new full chain starts after one month. Production
content is published from staging, so the staging content backup is the content
recovery source.

After each successful backup, a Compose-defined post-backup hook retains the
latest three full chains and their incrementals. This provides about three
months of history. Set `VOLUMERIZE_RETAIN_FULL_CHAINS` on both backup services
to change the retention count. Failed backups do not trigger pruning.

Create and inspect backups through the interactive menu:

```sh
./devops.sh
```

Select **Staging**, then **Backup Staging** or **List Staging Backups**.

Equivalent commands are:

```sh
docker exec "${SLD}-content-backups-stg" backup
docker exec "${SLD}-accounts-backups-stg" backup
docker exec "${SLD}-content-backups-stg" list
docker exec "${SLD}-accounts-backups-stg" list
```

The `list` operation can take several minutes when many chains exist.

Run retention manually when required:

```sh
docker exec "${SLD}-content-backups-stg" remove-all-but-n-full 3 --force
docker exec "${SLD}-accounts-backups-stg" remove-all-but-n-full 3 --force
```

This operation permanently deletes all older chains. Run a new backup and list
the repository after cleanup.

## Troubleshooting

### Remote connection failures

The context rides plain SSH. If remote Docker commands fail, test the
transport first:

```sh
ssh blt-pub02 docker version
```

SSH signing goes through the 1Password agent; an unlocked 1Password and
an approved `SSH blt-pub02` key are prerequisites. The old
docker-machine host (docker-ubuntu-4gb-sfo2-01) is retired; its
certificate tooling no longer applies.

### Shared proxy network

Staging and production use the existing `proxy-network`. Compose files declare
that network as external so Compose does not recreate or own it.

### Image cleanup

Review disk use before deleting images:

```sh
docker system df
```

Remove unused images only when disk pressure requires it:

```sh
docker image prune -a
```

### Certificate renewal

Run the Let’s Encrypt renewal command on the remote Docker host:

```sh
docker exec letsencrypt /app/force_renew
```
