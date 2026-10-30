#!/usr/bin/env bash

### ENV ##
# .env is a 1Password Environment pipe. A read can come back empty (locked,
# or the approval prompt missed), and the script would then run with blank
# secrets, so read it once and refuse when empty. Compose passes the values
# into the containers as environment; nothing is copied in afterwards.
ENV_CONTENT=$(cat .env 2>/dev/null)
[ -n "$ENV_CONTENT" ] || { echo ".env came back empty: unlock 1Password and approve the read, then rerun." >&2; exit 1; }
set -o allexport; eval "$ENV_CONTENT"; set +o allexport

# DOCKER_DEFAULT_PLATFORM from the login shell breaks remote compose/build
unset DOCKER_DEFAULT_PLATFORM

### Colors ##
ESC=$(printf '\033') RESET="${ESC}[0m" BLACK="${ESC}[30m" RED="${ESC}[31m"
GREEN="${ESC}[32m" YELLOW="${ESC}[33m" BLUE="${ESC}[34m" MAGENTA="${ESC}[35m"
CYAN="${ESC}[36m" WHITE="${ESC}[37m" DEFAULT="${ESC}[39m"

### Color Functions ##

greenprint() { printf "${GREEN}%s${RESET}\n" "$1"; }
blueprint() { printf "${BLUE}%s${RESET}\n" "$1"; }
redprint() { printf "${RED}%s${RESET}\n" "$1"; }
yellowprint() { printf "${YELLOW}%s${RESET}\n" "$1"; }
magentaprint() { printf "${MAGENTA}%s${RESET}\n" "$1"; }
cyanprint() { printf "${CYAN}%s${RESET}\n" "$1"; }

### Deployment Tasks ##

fn_goodafternoon() { echo; echo "Good afternoon."; }


fn_goodmorning() { 

    export DOCKER_CONTEXT="${DOCKER_CONTEXT:-blt-pub02}" && \
    echo $(yellowprint 'Docker context: ') $(blueprint ${DOCKER_CONTEXT}) && \
    docker --context desktop-linux buildx build --platform linux/amd64 --load -t wagnerpaul/${SLD}-main-app:stg . && \
    docker --context desktop-linux save wagnerpaul/${SLD}-main-app:stg | docker load && \
    docker-compose up -d --no-deps --no-build --force-recreate stg

}

### Utility Functions ##

fn_confirm() {
    # call with a prompt string or use a default
    read -r -p "${1:-Are you sure? [y/N]} " response
    case "$response" in
        [yY][eE][sS]|[yY]) 
            return 0
            ;;
        *)
            return 1
            ;;
    esac
}

fn_bye() { echo "Bye bye."; exit 0; }

fn_fail() { echo "Wrong option." exit 1; }

### Menu Functions ##
fn_docker_machine_ssh() {
    export DOCKER_CONTEXT="${DOCKER_CONTEXT:-blt-pub02}" && \
    echo $(yellowprint 'Docker context: ') $(blueprint ${DOCKER_CONTEXT}) && \
    ssh blt-pub02
}


fn_deployapp() {
    if fn_confirm "Would you really like to deploy the app to $1? [y/N]"
    then
        # the 2GB host never builds: build for amd64 on this Mac, ship the
        # image over the context, recreate only the app service
        export DOCKER_CONTEXT="${DOCKER_CONTEXT:-blt-pub02}" && \
        echo $(yellowprint 'Docker context: ') $(blueprint ${DOCKER_CONTEXT}) && \
        echo $(yellowprint "Building wagnerpaul/${SLD}-main-app:${1} for linux/amd64 on this Mac") && \
        docker --context desktop-linux buildx build --platform linux/amd64 --load -t wagnerpaul/${SLD}-main-app:${1} . && \
        echo $(yellowprint "Copying the image to ${DOCKER_CONTEXT}") && \
        docker --context desktop-linux save wagnerpaul/${SLD}-main-app:${1} | docker load && \
        docker-compose up -d --no-deps --no-build --force-recreate ${1}
    else
        redprint "Canceling app deployement to $1."
        $2
    fi
}

fn_promoteapp() {
    if fn_confirm "Would you really like to promote staging app to $1? [y/N]"
    then
        export DOCKER_CONTEXT="${DOCKER_CONTEXT:-blt-pub02}" && \
        echo $(yellowprint 'Docker context: ') $(blueprint ${DOCKER_CONTEXT}) && \
        echo $(yellowprint "Tagging image ${SLD}-main-app:stg as ${SLD}-main-app:latest") && \
        docker tag wagnerpaul/${SLD}-main-app:stg wagnerpaul/${SLD}-main-app:latest && \
        echo $(yellowprint "Pushing image ${SLD}-main-app:latest") && \
        docker push wagnerpaul/${SLD}-main-app:latest && \
        echo $(yellowprint "Tagging image ${SLD}-main-app:latest as ${SLD}-main-app:`date +%Y%m%d`") && \
        docker tag wagnerpaul/${SLD}-main-app:latest wagnerpaul/${SLD}-main-app:`date +%Y%m%d` && \
        echo $(yellowprint "Pushing image ${SLD}-main-app:`date +%Y%m%d`") && \
        docker push wagnerpaul/${SLD}-main-app:`date +%Y%m%d` && \
        docker-compose -f docker-compose.prod.yml up -d --force-recreate
        echo $(yellowprint "Clearing Cache On $1") && \
        docker exec -it ${SLD}-${1} sh -c 'rm -rf /app/storage/cache/* && mkdir -p "/app/storage/cache/$SERVER_NAME/pages" && chown -R www-data:www-data /app/storage/cache'
    else
        redprint "Canceling app promotion to $1."
        $2
    fi    
}

fn_promotecontent() {
    if fn_confirm "Would you really like to promote staging content to $1?
This will DELETE AND REPLACE all content on $1. [y/N]"
    then
        export DOCKER_CONTEXT="${DOCKER_CONTEXT:-blt-pub02}" && \
        echo $(yellowprint 'Docker context: ') $(blueprint ${DOCKER_CONTEXT}) && \
        echo $(yellowprint "Deleting Content On $1") && \
        docker exec -it ${SLD}-${1} sh -c 'rm -rf /app/content/*'  && \
        echo $(yellowprint "Copying Content from stg to $1") && \
        docker container run --rm -it \
           -v ${SLD}-stg-content:/from \
           -v ${SLD}-prod-content:/to \
           alpine ash -c "cd /from ; cp -av . /to" && \
        echo $(yellowprint "Setting Permissions On $1") && \
        docker exec -it ${SLD}-${1} sh -c 'chown -R www-data:www-data /app/content' && \
        echo $(yellowprint "Deleting Cache On $1") && \
        docker exec -it ${SLD}-${1} sh -c 'rm -rf /app/storage/cache/* && mkdir -p "/app/storage/cache/$SERVER_NAME/pages" && chown -R www-data:www-data /app/storage/cache' && \
        echo $(yellowprint "Finished Content Push to $1")
    else
        redprint "Canceling content promotion to $1."
        $2
    fi    

}

fn_pushcontent() {
    if fn_confirm "Would you really like to push content to $1?
This will DELETE AND REPLACE all content on $1. [y/N]"
    then
        fn_pushcontent_atomic "$1"

    else 
        redprint "Canceling content push to $1."
        $2
    fi
}

fn_pushcontent_atomic() {
    local target=${1:-stg}
    local sync_container="${SLD}-content-sync"

    if [ "$target" != "stg" ]; then
        redprint "Atomic local content pushes are restricted to staging."
        return 1
    fi
    if [ ! -f ./content/site.en.txt ]; then
        redprint "Local content failed validation: content/site.en.txt is missing."
        return 1
    fi

    export DOCKER_CONTEXT="${DOCKER_CONTEXT:-blt-pub02}" || return 1
    echo $(yellowprint 'Docker context: ') $(blueprint ${DOCKER_CONTEXT})

    docker rm -f "$sync_container" >/dev/null 2>&1 || true
    # the B2 backup below can run past an hour on a new chain; the helper
    # must outlive it or the replace step execs into a dead container
    docker create --name "$sync_container" \
        -v "${SLD}-stg-content:/target" \
        alpine sleep 7200 >/dev/null || return 1
    docker cp ./content "$sync_container:/incoming" || {
        docker rm -f "$sync_container" >/dev/null
        return 1
    }
    docker start "$sync_container" >/dev/null || return 1
    docker exec "$sync_container" test -f /incoming/site.en.txt || {
        redprint "Uploaded content failed validation. Staging was not changed."
        docker rm -f "$sync_container" >/dev/null
        return 1
    }

    yellowprint "Backing up current staging content before replacement."
    docker exec "${SLD}-content-backups-stg" /etc/periodic/daily/jobrunner || {
        redprint "Backup failed. Staging was not changed."
        docker rm -f "$sync_container" >/dev/null
        return 1
    }

    docker stop "${SLD}-stg" >/dev/null || return 1
    if docker exec "$sync_container" sh -c '
        rm -rf /rollback && mkdir /rollback &&
        cp -a /target/. /rollback/ &&
        find /target -mindepth 1 -maxdepth 1 -exec rm -rf {} + &&
        cp -a /incoming/. /target/ &&
        chown -R 82:82 /target  # www-data in the php:fpm-alpine image
    '; then
        docker start "${SLD}-stg" >/dev/null
        docker rm -f "$sync_container" >/dev/null
        docker exec "${SLD}-stg" test -f /app/public/assets/css/site.css || return 1
        # pages rendered from the old content stay cached otherwise
        docker exec "${SLD}-stg" sh -c 'rm -rf /app/storage/cache/* && mkdir -p "/app/storage/cache/$SERVER_NAME/pages" && chown -R www-data:www-data /app/storage/cache' || return 1
        fn_verify_staging_https || return 1
        greenprint "Local content is live on staging and custom CSS was regenerated."
    else
        redprint "Replacement failed; restoring the previous staging content."
        docker exec "$sync_container" sh -c '
            find /target -mindepth 1 -maxdepth 1 -exec rm -rf {} + &&
            cp -a /rollback/. /target/ &&
            chown -R 82:82 /target  # www-data in the php:fpm-alpine image
        '
        docker start "${SLD}-stg" >/dev/null
        docker rm -f "$sync_container" >/dev/null
        return 1
    fi
}

fn_verify_staging_https() {
    local staging_host="stg.${SLD}.${TLD}"
    local staging_url="https://${staging_host}/"
    local html
    local http_media_count
    local https_media_count
    local attempt=1

    export DOCKER_CONTEXT="${DOCKER_CONTEXT:-blt-pub02}" || return 1

    # The staging page cache stores absolute media URLs. Remove the homepage
    # entry before verification so an internal HTTP request cannot persist
    # mixed-content URLs.
    docker exec "${SLD}-stg" sh -c \
        "find '/app/storage/cache/${staging_host}/pages' -maxdepth 1 -type f -name 'home-en-html_*.cache' -delete 2>/dev/null; true" \
        || return 1

    while [ "$attempt" -le 10 ]; do
        if html=$(curl -fsS -u "${BASIC_AUTH_USER}:${BASIC_AUTH_PASSWORD}" "$staging_url"); then
            break
        fi
        attempt=$((attempt + 1))
        sleep 2
    done

    if [ -z "${html:-}" ]; then
        redprint "Staging did not respond over HTTPS."
        return 1
    fi

    http_media_count=$(printf '%s' "$html" | grep -o "http://${staging_host}/media/" | wc -l | tr -d ' ')
    https_media_count=$(printf '%s' "$html" | grep -o "https://${staging_host}/media/" | wc -l | tr -d ' ')

    if [ "$http_media_count" -ne 0 ] || [ "$https_media_count" -eq 0 ]; then
        redprint "Staging homepage media URL verification failed: HTTP=${http_media_count}, HTTPS=${https_media_count}."
        return 1
    fi

    greenprint "Staging homepage verified over HTTPS with ${https_media_count} media URLs."
}

fn_pullcontent() {
    if fn_confirm "Would you really like to pull content from $1?
This will DELETE AND REPLACE all content on localhost. [y/N]"
    then
        fn_synccontent "$1"

    else 
        redprint "Canceling content pull from $1."
        $2
    fi
}

fn_synccontent() {
    local source=${1:-stg}
    local sync_dir
    sync_dir=$(mktemp -d "${TMPDIR:-/tmp}/blt-content-sync.XXXXXX") || return 1

    export DOCKER_CONTEXT="${DOCKER_CONTEXT:-blt-pub02}" || return 1
    echo $(yellowprint 'Docker context: ') $(blueprint ${DOCKER_CONTEXT})
    docker cp "${SLD}-${source}:/app/content" "${sync_dir}/" || return 1

    if [ ! -f "${sync_dir}/content/site.en.txt" ]; then
        redprint "Downloaded content failed validation. Local content was not changed."
        return 1
    fi

    [ ! -d ./content ] || mv ./content "${sync_dir}/content.previous" || return 1
    if mv "${sync_dir}/content" ./content; then
        rm -rf "${sync_dir}/content.previous"
        rmdir "${sync_dir}"
        greenprint "Local content now matches ${source}."
    else
        redprint "Could not install downloaded content; restoring the previous copy."
        [ ! -d "${sync_dir}/content.previous" ] || mv "${sync_dir}/content.previous" ./content
        return 1
    fi
}

fn_backup() {
    export DOCKER_CONTEXT="${DOCKER_CONTEXT:-blt-pub02}" && \
    echo $(yellowprint 'Docker context: ') $(blueprint ${DOCKER_CONTEXT}) && \
    echo $(yellowprint "Backing Up Content On $1") && \
    docker exec ${SLD}-content-backups-${1} /etc/periodic/daily/jobrunner  && \
    echo $(yellowprint "Backing Up Accounts On $1") && \
    docker exec ${SLD}-accounts-backups-${1} /etc/periodic/daily/jobrunner
}

fn_listbackups() {
    export DOCKER_CONTEXT="${DOCKER_CONTEXT:-blt-pub02}" && \
    echo $(yellowprint 'Docker context: ') $(blueprint ${DOCKER_CONTEXT}) && \
    echo $(yellowprint "Content Backups On $1") && \
    docker exec ${SLD}-content-backups-${1} sh -c 'dup collection-status $DST'  && \
    echo $(yellowprint "Accounts Backups On $1") && \
    docker exec ${SLD}-accounts-backups-${1} sh -c 'dup collection-status $DST'
}
fn_recreatebackups() { # stg
    # Picks up .env (new B2 key, endpoint) and compose changes. The duplicity
    # cache lives in a named volume, so the chain continues without a re-sync.
    if fn_confirm "Recreate the $1 backup containers from .env and docker-compose.yml? [y/N]"
    then
        export DOCKER_CONTEXT="${DOCKER_CONTEXT:-blt-pub02}" && \
        echo $(yellowprint 'Docker context: ') $(blueprint ${DOCKER_CONTEXT}) && \
        docker-compose up -d --no-deps --force-recreate backups-content-${1} backups-accounts-${1} && \
        fn_backup "$1"
    else
        redprint "Canceling backup container recreation on $1."
        $2
    fi
}

fn_restore() {
    echo -ne "
$(yellowprint 'Restore Should Be Handled With Care')
$(greenprint 'Accounts and content should be considered independently.')
$(greenprint 'Restore time point should be considered carefully.')

$(yellowprint 'Command Example')
$(blueprint 'set -o allexport; source .env; set +o allexport && \')
$(blueprint 'export DOCKER_CONTEXT=blt-pub02 && \')
$(blueprint "docker exec ${SLD}-content-backups-${1} sh -c 'dup restore -t 3D --force \$DST \$SRC'")

$(yellowprint 'Documentation')
$(cyanprint 'https://github.com/Tecnativa/docker-duplicity')
    "
}

fn_getshell() {
    export DOCKER_CONTEXT="${DOCKER_CONTEXT:-blt-pub02}" && \
    echo $(yellowprint 'Docker context: ') $(blueprint ${DOCKER_CONTEXT}) && \
    echo $(yellowprint "Getting shell for:") $(blueprint ${1} ) && \
    docker exec -it ${SLD}-${1} /bin/sh
}

fn_buildimage(){
    # local image for menu_localhost; built on the Mac, never on the host
    echo $(yellowprint "Building wagnerpaul/${SLD}-main-app:${1} on this Mac") && \
    docker --context desktop-linux build -t wagnerpaul/${SLD}-main-app:${1} .
}

### Menus ##
menu_staging() {
    echo -ne "
$(blueprint 'CHOOSE TASK')
$(greenprint '1)') Deploy Staging App
$(blueprint '2)') Push Local Content -> Staging
$(cyanprint '3)') Backup Staging
$(yellowprint '4)') List Staging Backups
$(blueprint '5)') Restore Staging Backups
$(greenprint '6)') Get Staging Shell
$(cyanprint '7)') Recreate Staging Backup Containers

$(magentaprint 'M)') Go Back to Main Menu
$(redprint '0)') Exit
Choose an option:  "
    read -r ans
    case $ans in
    1)
        fn_deployapp stg menu_staging
        menu_staging
        ;;
    7)
        fn_recreatebackups stg menu_staging
        menu_staging
        ;;
    2)
        fn_pushcontent stg menu_staging
        menu_staging
        ;;
    3)
        fn_backup stg menu_staging
        menu_staging
        ;;
    4)
        fn_listbackups stg menu_staging
        menu_staging
        ;;
    5)
        fn_restore stg menu_staging
        menu_staging
        ;;
    6)
        fn_getshell stg menu_staging
        menu_staging
        ;;
    m)
        menu_mainmenu
        ;;
    0|[eE]xit)
        fn_bye
        ;;
    *)
        fn_fail
        ;;
    esac
}

menu_localhost() {
    echo -ne "
$(blueprint 'CHOOSE TASK')
$(greenprint '1)') Pull Staging Content -> Local
$(blueprint '2)') Build Image
$(cyanprint '3)') Run Container From Image

$(magentaprint 'M)') Go Back to Main Menu
$(redprint '0)') Exit
Choose an option:  "
    read -r ans
    case $ans in
    1)
        fn_pullcontent stg menu_localhost
        menu_localhost
        ;;
    2)
        DOCKER_MACHINE='-u' fn_buildimage local menu_localhost
        menu_localhost
        ;;
    3)
        docker run -d -v "`pwd`":/app -p 80:80 -e ENABLE_PANEL=true --name ${SLD}-local wagnerpaul/${SLD}-main-app:local
        menu_localhost
        ;;
    m)
        menu_mainmenu
        ;;
    0|[eE]xit)
        fn_bye
        ;;
    *)
        fn_fail
        ;;
    esac
}


menu_production() {
    echo -ne "
$(blueprint 'CHOOSE TASK')
$(greenprint '1)') Promote Production App
$(blueprint '2)') Promote Staging Content -> Production
$(greenprint '3)') Get Production Shell

$(magentaprint 'M)') Go Back to Main Menu
$(redprint '0)') Exit
Choose an option:  "
    read -r ans
    case $ans in
    1)
        fn_promoteapp prod menu_production
        menu_production
        ;;
    2)
        fn_promotecontent prod menu_production
        menu_production
        ;;
    3)
        fn_getshell prod menu_production
        menu_production
        ;;
    m)
        menu_mainmenu
        ;;
    0|[eE]xit)
        fn_bye
        ;;
    *)
        fn_fail
        ;;
    esac
}

menu_mainmenu() {
    echo -ne "
$(magentaprint 'CHOOSE DOCKER TARGET')
$(greenprint '1)') Staging
$(blueprint '2)') Localhost
$(cyanprint '3)') Production
$(yellowprint '4)') Docker-Machine SSH

$(redprint '0)') Exit
Choose an option:  "
    read -r ans
    case $ans in
    1|[sS]|[sS]tg|[sS]taging)
        menu_staging
        menu_mainmenu
        ;;
    2|[lL]|[lL]ocal|[lL]ocalhost)
        menu_localhost
        menu_mainmenu
        ;;
    3|[pP]|[pP]rod|[pP]roduction)
        menu_production
        menu_mainmenu
        ;;
    4|ssh)
        fn_docker_machine_ssh
        menu_mainmenu
        ;;
    0|[eE]|[eE]xit)
        fn_bye
        ;;
    *)
        fn_fail
        ;;
    esac
}

case "${1:-}" in
    sync-stg)
        fn_synccontent stg
        ;;
    push-stg)
        if fn_confirm "Back up staging and replace its content with local content? [y/N]"; then
            fn_pushcontent_atomic stg
        else
            redprint "Canceling content push to staging."
        fi
        ;;
    verify-stg)
        fn_verify_staging_https
        ;;
    "")
        menu_mainmenu
        ;;
    *)
        redprint "Unknown command: $1"
        echo "Usage: $0 [sync-stg|push-stg|verify-stg]"
        exit 1
        ;;
esac
