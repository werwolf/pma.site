<?php
if (!defined("entrypoint"))die;

files::init($db, $viewextensions,MAX_FILE_SIZE);

if(Root::POSTExists("filename"))
{
       if(files::checkExtension(Root::POSTString("filename")))
            print 'true';
        else
            print 'false';
}

if(Root::POSTExists("cover"))
{
    if(files::checkPicture($pictures,Root::POSTString("cover")))
        print 'true';
    else
        print 'false';
}

?>
