#!/bin/bash

cd ..
cp -r timeclock backups/$(date +"%d-%m-%y_%T")
echo "Backup complete."

