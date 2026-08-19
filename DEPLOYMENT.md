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
- Docker Machine for remote staging and production operations
- A project `.env` file
- Access to the `docker-ubuntu-4gb-sfo2-01` Docker Machine

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
eval "$(docker-machine env -u)"
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
4. Build and deploy the branch image to staging.
5. Verify staging before promoting the image to production.

Never publish an untested application image directly to production.

## Remote Docker access

Load the project environment and select the remote Docker host:

```sh
set -o allexport
source .env
set +o allexport
eval "$(docker-machine env "${DOCKER_MACHINE}")"
```

Open a staging shell:

```sh
docker exec -it "${SLD}-stg" /bin/sh
```

Open a production shell:

```sh
docker exec -it "${SLD}-prod" /bin/sh
```

The remote daemon runs Docker 19.03. Current Docker Compose versions can reject
some recreate operations because the daemon supports API 1.40. Do not use
`--remove-orphans`. Staging and production share the Compose project and proxy
network.

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

### Expired Docker Machine certificates

If Docker reports an expired TLS certificate, regenerate the CA and client
certificates:

```sh
docker-machine regenerate-certs --client-certs -f \
  docker-ubuntu-4gb-sfo2-01
```

Confirm access with:

```sh
docker-machine ls
```

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
