#!/bin/bash

source ./../.env

json_files=(
    "github-events.json"
    "gitlab-events.json"
    "tgn-settings.json"
)

destination_dir="./../storage/app/tgn-json"
if [ -z $TGN_DIR_SETTING ]; then
    destination_dir=$TGN_DIR_SETTING
fi

mkdir -p "$destination_dir"

for file in "${json_files[@]}"; do
    if [ ! -f "$destination_dir/$file" ]; then
        cp "vendor/lbiltech/telegram-git-notifier/config/jsons/$file" "$destination_dir/$file"
    fi
done

chmod -R 777 $destination_dir/*.json
