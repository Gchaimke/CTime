if [ $# -eq 0 ]
then
    echo "No arguments supplied"
else
    folder=$1
    mkdir $folder
    cp -pv --parents $(git diff --name-only) $folder
    tar cvf $folder.tar $folder
    rm -r $folder
fi
