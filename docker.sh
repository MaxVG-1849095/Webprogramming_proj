#!/bin/sh
docker build -t projsitedocker .
docker run -p "8080:80" -v ${PWD}/codeigniter:/app -v ${PWD}/mysql:/var/lib/mysql projsitedocker