<?php
if (!defined("entrypoint"))die;

files::init($db, $viewextensions,MAX_FILE_SIZE);

if(files::checkExtension(Root::POSTString("filename")) && files::checkPicture($pictures,Root::POSTString("cover")))
{
    print 'true';
}
else
{
    print 'false';
}
?>
