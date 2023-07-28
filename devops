#!/usr/bin/env bash

### ENV ##
set -o allexport; source .env; set +o allexport;

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

    eval $(docker-machine env ${DOCKER_MACHINE}) && \
    echo $(yellowprint 'Active Docker Machine: ') $(blueprint `docker-machine active` ) && \
    docker build -t wagnerpaul/${SLD}-main-app:stg . && \
    docker-compose up -d --force-recreate

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
    eval $(docker-machine env ${DOCKER_MACHINE}) && \
    echo $(yellowprint 'Active Docker Machine: ') $(blueprint `docker-machine active` ) && \
    docker-machine ssh ${DOCKER_MACHINE}
}


fn_deployapp() {
    if fn_confirm "Would you really like to deploy the app to $1? [y/N]"
    then
        eval $(docker-machine env ${DOCKER_MACHINE}) && \
        echo $(yellowprint 'Active Docker Machine: ') $(blueprint `docker-machine active` ) && \
        docker build -t wagnerpaul/${SLD}-main-app:${1} . && \
        docker-compose up -d --force-recreate
        echo $(yellowprint "Copying .env File To $1") && \
        docker cp ./.env ${SLD}-${1}:app
        echo $(yellowprint "Creating .htpasswd File On $1") && \
        docker exec -it ${SLD}-${1} sh -c 'set -o allexport; source .env; set +o allexport; htpasswd -c -B -b /etc/nginx/.htpasswd $BASIC_AUTH_USER $BASIC_AUTH_PASSWORD'
    else 
        redprint "Canceling app deployement to $1."
        $2
    fi
}

fn_promoteapp() {
    if fn_confirm "Would you really like to promote staging app to $1? [y/N]"
    then
        eval $(docker-machine env ${DOCKER_MACHINE}) && \
        echo $(yellowprint 'Active Docker Machine: ') $(blueprint `docker-machine active` ) && \
        echo $(yellowprint "Tagging image ${SLD}-main-app:stg as ${SLD}-main-app:latest") && \
        docker tag wagnerpaul/${SLD}-main-app:stg wagnerpaul/${SLD}-main-app:latest && \
        echo $(yellowprint "Pushing image ${SLD}-main-app:latest") && \
        docker push wagnerpaul/${SLD}-main-app:latest && \
        echo $(yellowprint "Tagging image ${SLD}-main-app:latesgt as ${SLD}-main-app:`date +%Y%m%d`") && \
        docker tag wagnerpaul/${SLD}-main-app:latest wagnerpaul/${SLD}-main-app:`date +%Y%m%d` && \
        echo $(yellowprint "Pushing image ${SLD}-main-app:`date +%Y%m%d`") && \
        docker push wagnerpaul/${SLD}-main-app:`date +%Y%m%d` && \
        docker-compose -f docker-compose.prod.yml up -d --force-recreate
        echo $(yellowprint "Clearing Cache On $1") && \
        docker exec -it ${SLD}-${1} sh -c 'rm -rf /app/storage/cache/*'
    else
        redprint "Canceling app promotion to $1."
        $2
    fi    
}

fn_promotecontent() {
    if fn_confirm "Would you really like to promote staging content to $1?
This will DELETE AND REPLACE all content on $1. [y/N]"
    then
        eval $(docker-machine env ${DOCKER_MACHINE}) && \
        echo $(yellowprint 'Active Docker Machine: ') $(blueprint `docker-machine active` ) && \
        echo $(yellowprint "Deleting Content On $1") && \
        docker exec -it ${SLD}-${1} sh -c 'rm -rf /app/content/*'  && \
        echo $(yellowprint "Copying Content from stg to $1") && \
        docker container run --rm -it \
           -v ${SLD}-stg-content:/from \
           -v ${SLD}-prod-content:/to \
           alpine ash -c "cd /from ; cp -av . /to" && \
        echo $(yellowprint "Setting Permissions On $1") && \
        docker exec -it ${SLD}-${1} sh -c 'chown -R nobody:nobody /app/content' && \
        echo $(yellowprint "Deleting Cache On $1") && \
        docker exec -it ${SLD}-${1} sh -c 'rm -rf /app/storage/cache/*' && \
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
        eval $(docker-machine env ${DOCKER_MACHINE}) && \
        echo $(yellowprint 'Active Docker Machine: ') $(blueprint `docker-machine active` ) && \
        docker exec -it ${SLD}-${1} sh -c 'rm -rf /app/content/*'  && \
        docker cp ./content ${SLD}-${1}:app && \
        echo $(yellowprint "Setting Permissions On $1") && \
        docker exec -it ${SLD}-${1} sh -c 'chown -R nobody:nobody /app/content' && \
        echo $(yellowprint "Files Now in Content On $1") && \
        docker exec -it ${SLD}-${1} sh -c 'ls -la /app/content' && \
        echo $(yellowprint "Deleting Cache On $1") && \
        docker exec -it ${SLD}-${1} sh -c 'rm -rf /app/storage/cache/*' && \
        echo $(yellowprint "Finished Content Push to $1")

    else 
        redprint "Canceling content push to $1."
        $2
    fi
}

fn_pullcontent() {
    if fn_confirm "Would you really like to pull content from $1?
This will DELETE AND REPLACE all content on localhost. [y/N]"
    then


        eval $(docker-machine env ${DOCKER_MACHINE}) && \
        echo $(yellowprint 'Active Docker Machine: ') $(blueprint `docker-machine active` ) && \
        rm -Rf ./content/* && \
        docker cp ${SLD}-stg:app/content . && \
        echo $(yellowprint "Files Now in Content On localhost") && \
        ls -la ./content && \
        echo $(yellowprint "Finished Content Pull from $1")

    else 
        redprint "Canceling content pull from $1."
        $2
    fi
}

fn_backup() {
    eval $(docker-machine env ${DOCKER_MACHINE}) && \
    echo $(yellowprint 'Active Docker Machine: ') $(blueprint `docker-machine active` ) && \
    echo $(yellowprint "Backing Up Content On $1") && \
    docker exec ${SLD}-content-backups-${1} backup  && \
    echo $(yellowprint "Backing Up Accounts On $1") && \
    docker exec ${SLD}-accounts-backups-${1} backup
}

fn_listbackups() {
    eval $(docker-machine env ${DOCKER_MACHINE}) && \
    echo $(yellowprint 'Active Docker Machine: ') $(blueprint `docker-machine active` ) && \
    echo $(yellowprint "Content Backups On $1") && \
    docker exec ${SLD}-content-backups-${1} list  && \
    echo $(yellowprint "Accounts Backups On $1") && \
    docker exec ${SLD}-accounts-backups-${1} list
}
fn_restore() {
    echo -ne "
$(yellowprint 'Restore Should Be Handled With Care')
$(greenprint 'Accounts and content should be considered independently.')
$(greenprint 'Restore time point should be considered carefully.')

$(yellowprint 'Command Example')
$(blueprint 'set -o allexport; source .env; set +o allexport && \')
$(blueprint 'eval $(docker-machine env ${DOCKER_MACHINE}) && \')
$(blueprint "docker exec ${SLD}-content-backups-${1} restore -t 3D")

$(yellowprint 'Documentation')
$(cyanprint 'https://github.com/blacklabelops/volumerize')
    "
}

fn_getshell() {
    eval $(docker-machine env ${DOCKER_MACHINE}) && \
    echo $(yellowprint 'Active Docker Machine: ') $(blueprint `docker-machine active` ) && \
    echo $(yellowprint "Getting shell for:") $(blueprint ${1} ) && \
    docker exec -it ${SLD}-${1} /bin/sh
}

fn_buildimage(){
    eval $(docker-machine env ${DOCKER_MACHINE}) && \
    echo $(yellowprint 'Active Docker Machine: ') $(blueprint `docker-machine active` )
   docker build -t wagnerpaul/${SLD}-main-app:${1} .
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

$(magentaprint 'M)') Go Back to Main Menu
$(redprint '0)') Exit
Choose an option:  "
    read -r ans
    case $ans in
    1)
        fn_deployapp stg menu_staging
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

menu_mainmenu