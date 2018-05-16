#!/bin/bash

#set  BucketName AppId Environment
#echo $1 $2 $3
  
sudo aws s3 cp s3://$1/env_files/$3/$2/.env  .
  