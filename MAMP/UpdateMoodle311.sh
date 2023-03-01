#! /bin/sh
#
#  This GIT installer for macOS is part 
#  of the installation package Moodle4Mac
# 
#  20220111 - Ralf Krause
#

echo
echo "+--------------------------------------------+"
echo "| GIT updater for your local Moodle server"
echo "+--------------------------------------------+"
echo

cd /Applications/MAMP/htdocs

if ! test -e moodle311/.git ; then
    ## the first git update must get everything including .git
    git clone --depth 1 -b MOODLE_311_STABLE https://github.com/moodle/moodle.git moodle311-git
    if test -e moodle311-git ; then
        if test -e moodle311 ; then
            if test -e moodle311/config.php ; then
                cp moodle311/config.php moodle311-git/.
            fi
            DATE=`date +%Y%m%d-%H%M`
            mv moodle311 moodle311-$DATE
        fi
        mv moodle311-git moodle311
    fi
    ## the old folder can be deleted now
    ## if you want to do this please remove '##' from the following line
    ## rm -R moodle311-*
else
    ## the next git update only gets the new files
    cd moodle311
    git pull
    cd ..
fi
