#!/bin/bash
rm -rf vk_auto_post/
git clone https://github.com/Vladislav719/vk_auto_post.git
rm main.php
rm groups.dat
mv vk_auto_post/main.php ./
mv vk_auto_post/groups.dat ./

echo -en "\033[37;1;41m All Done!!! \033[0m \n"
