#!/bin/bash

__file_exists() {
    test -f "$1"
}

export UID
if [ "$#" == "0" ]; then
    docker run --rm --user $UID:$UID -w "/terraform" -v "$(pwd)/terraform":/terraform hashicorp/terraform
else
    if [ "$@" == "fmt" ]; then
        docker run --rm --user $UID:$UID -w "/terraform" -v "$(pwd)/terraform":/terraform hashicorp/terraform $@
    else
        if __file_exists "$(pwd)/.env.terraform"; then
            if [ "$@" == "init" ]; then
                docker run --rm --user $UID:$UID --entrypoint= --env-file "$(pwd)/.env.terraform" -w "/terraform" -v "$(pwd)/terraform":/terraform hashicorp/terraform sh -c 'terraform init \
                    -backend-config bucket=$TF_VAR_backend_s3_bucket \
                    -backend-config region=$TF_VAR_backend_s3_region \
                    -backend-config access_key=$TF_VAR_backend_s3_access_key \
                    -backend-config secret_key=$TF_VAR_backend_s3_secret_key \
                    -backend-config key=$TF_VAR_app_name'
            else
                docker run --rm --user $UID:$UID -w "/terraform" -v "$(pwd)/terraform":/terraform hashicorp/terraform $@
            fi
        else 
            echo "Please create the .env.terraform file before running terraform. See terraform/README.md for more help"
            exit 1
        fi
    fi
fi
