# Quick & Dirty Docker PHP v5.6 & v7.4 Containers

To build docker image: `docker-compose -f <file_name> up -d --build`

If the Dockerfile is modified, then the image needs to be built again using the above command.

You could rebuild individual containers with `docker-compose -f <file_name> up -d --no-deps --build <service_name>` command.
