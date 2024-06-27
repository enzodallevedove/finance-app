#!/bin/bash

process_file() {
    local file=$1
    echo "Processing file: $file"
    ./vendor/bin/phpcbf --standard=PSR12 $file --colors
    ./vendor/bin/phpcs --standard=PSR12 $file --colors
}

process_directory() {
    local dir=$1
    echo "Processing directory: $dir"
    # Add your directory processing commands here
    for file in "$dir"/*; do
        if [ -f "$file" ]; then
            process_file "$file"
        elif [ -d "$file" ]; then
            process_directory "$file"
        fi
    done
}

# Main script logic
for item in "$@"; do
    if [ -f "$item" ]; then
        process_file "$item"
    elif [ -d "$item" ]; then
        process_directory "$item"
    else
        echo "Invalid input: $item is neither a file nor a directory"
    fi
done
