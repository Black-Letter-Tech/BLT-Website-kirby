*Useful Docker Reference*
note: the "SLD" environment variable refers to Second Level Domain


**Build local dev**
    
    set -o allexport; source .env; set +o allexport && \
    eval $(docker-machine env -u) && \
    docker build -t wagnerpaul/${SLD}-main-app:local .

**Run local dev container with interactive (-i flag) output for debugging, or detached (-d flag) to give you back the shell**

    set -o allexport; source .env; set +o allexport && \
    eval $(docker-machine env -u) && \
    docker run -i -v "`pwd`":/app -p 80:80 -e ENABLE_PANEL=true --name ${SLD}-local wagnerpaul/${SLD}-main-app:local
    docker run -d -v "`pwd`":/app -p 80:80 -e ENABLE_PANEL=true --name ${SLD}-local wagnerpaul/${SLD}-main-app:local



*Building Staging and Prod*

**create stg volumes**

    set -o allexport; source .env; set +o allexport && \
    eval $(docker-machine env ${DOCKER_MACHINE}) && \
    docker volume create --name=${SLD}-stg-content && \
    docker volume create --name=${SLD}-stg-media && \
    docker volume create --name=${SLD}-stg-sessions

**create accounts volume which is same on stg and prod**

    set -o allexport; source .env; set +o allexport && \
    eval $(docker-machine env ${DOCKER_MACHINE}) && \
    docker volume create --name=${SLD}-accounts

**build and deploy for stg, stg.blackletter.tech**
note: memory can be a little low so just `docker-machine ssh docker-ubuntu-4gb-sfo2-01` and `reboot now`

    set -o allexport; source .env; set +o allexport && \
    eval $(docker-machine env ${DOCKER_MACHINE}) && \
    docker build -t wagnerpaul/${SLD}-main-app:stg . && \
    docker-compose up -d --force-recreate

**create prod volumes**

    set -o allexport; source .env; set +o allexport && \
    eval $(docker-machine env ${DOCKER_MACHINE}) && \
    docker volume create --name=${SLD}-prod-content && \
    docker volume create --name=${SLD}-prod-media && \
    docker volume create --name=${SLD}-prod-sessions

**build and deploy for prod**
note: modified into a promote strategy in the deploy.sh

    set -o allexport; source .env; set +o allexport && \
    eval $(docker-machine env ${DOCKER_MACHINE}) && \
    docker build -t wagnerpaul/${SLD}-main-app:latest . && \
    docker push wagnerpaul/${SLD}-main-app:latest && \
    docker tag wagnerpaul/${SLD}-main-app:latest wagnerpaul/${SLD}-main-app:`date +%Y%m%d` && \
    docker push wagnerpaul/${SLD}-main-app:`date +%Y%m%d` && \
    docker-compose -f docker-compose.prod.yml up -d --force-recreate



*Commands for other tasks*

**get remote shell**
    
    set -o allexport; source .env; set +o allexport && \
    eval $(docker-machine env ${DOCKER_MACHINE}) && \
    docker exec -it ${SLD}-stg /bin/sh   
    docker exec -it ${SLD}-prod /bin/sh

**copy files to remote docker app**
    
    set -o allexport; source .env; set +o allexport && \
    eval $(docker-machine env ${DOCKER_MACHINE}) && \

    docker exec -it ${SLD}-stg sh -c 'rm -rf /app/content/*'  && \
    docker cp ./content ${SLD}-stg:app && \
    docker cp ./storage/accounts ${SLD}-stg:app/storage



**copy files from remote docker app**

    set -o allexport; source .env; set +o allexport && \
    docker cp ${SLD}-stg:app/content .
    docker cp ${SLD}-stg:app/storage/accounts storage/ .

**periodic cleanup commands**
https://docs.docker.com/engine/reference/commandline/image_prune/
    
    docker image prune -a

**letsencrypt certificate renew commands**

    set -o allexport; source .env; set +o allexport && \
    docker exec letsencrypt /app/force_renew

test
