<?php
if (!defined("entrypoint"))die;
require_once("classes/calendar/class.calendar.php");
$calendar = new calendar($db);

if(Root::POSTExists("addMessage"))
{
    $now = getdate();
    if($calendar->addMessage($user->getUserId(),$now['year']."-".Root::POSTString("month")."-".Root::POSTString("day")))
        print $labels['calendar']['addSuccess'];
    else
        print $labels['calendar']['addError'];
}
else if(Root::POSTExists("getMessages"))
{
    $now = getDate();
    $date = $now['year']."-".Root::POSTInt("month")."-".Root::POSTInt("day");
    
    if(Root::POSTString("getMessages") == "mymes")
    {
        $type = "my";
        if(!$calendar->getMyMessagesByDate($date,$user->getUserId()))
                die("Error");
    }
    else if(Root::POSTString("getMessages") == "inbox")
    {
        $type = "inbox";
        if(!$calendar->getInboxMessagesByDate($date,$user->getUserId()))
                die("Error");
    }
    require_once("view/profile/calendar_template/inbox_messages.php");
}
else
{
    $now = getdate();

    $View->current_month = $now['mon'];
    if(Root::POSTExists("month") && Root::POSTInt("year") <= $now['year'])
        $now['mon'] = Root::POSTInt("month");

    $calendar->makeCalendar($now['year'], $now['mon']);
    $calendar->getDateWithMessages(array('month'=>$now['mon'],'year'=>$now['year']),$user->getUserId());
    
    if($now['mon'] > 9)
        $View->month = $labels['calendar']['month_'.$now['mon']]." ".$now['year'];
    else
        $View->month = $labels['calendar']['month_0'.$now['mon']]." ".$now['year'];

    $View->month_c = $now['mon'];

    require_once("view/profile/calendar_template/calendar.php");
}
?>
