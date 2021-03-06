<?
require_once("time_functions.php");


include( 'functions.php' );
include('player.php');

f_MConnect( );

f_MQuery( "DELETE FROM player_quest_values WHERE value_id=26" );
f_MQuery( "UPDATE player_caveexp SET tries_left = 0" );
f_MQuery( "DELETE FROM player_portal_visits" );

f_MQuery( "DELETE FROM player_triggers WHERE trigger_id=225 AND player_id IN ( SELECT player_id FROM player_quest_values WHERE value_id=44 AND value < ".time( )." )" );


// Удаление вчерашней активности в локациях
$locationsVisits = f_MQuery( 'SELECT * FROM `location_visits`' );
while( $visits = f_MFetch( $locationsVisits ) )
{
	f_MQuery( "UPDATE `location_visits` SET `visits` = `visits` - `to_subtraction`, `to_subtraction` = `visits` WHERE `loc` = $visits[loc] AND `depth` = $visits[depth]" );
}

/*
$res = f_MQuery("SELECT player_id FROM player_effects WHERE effect_id=5");
while ($arr=f_MFetch($res))
{
	$plr = new Player($arr[0]);
	$plr->RemoveEffect(5, true);
}
*/

// Эффект номер восемь, player_quest_values #12900

$res = f_MQuery("SELECT player_id, value FROM player_quest_values WHERE value_id=12900");
while ($arr=f_MFetch($res))
{
	$plr = new Player($arr[0]);
	$plr->AddMoney($arr[1]);
	$plr->AddToLogPost(0, $arr[1], 985);
}

// Зал Славы - Награждение

$t = time();

$str1 = "Охотник за головами";
$str2 = "Ежедневно начисляет 1000 дублонов за лидерство в своей группе\nЗа первое место в истреблении ";
$str1= iconv("UTF-8", "CP1251", $str1);
$str2= iconv("UTF-8", "CP1251", $str2);

$res = f_MQuery("SELECT * FROM mobs");
while ($arr=f_MFetch($res))
{
	$res1 = f_MQuery("SELECT mob_wins.player_id, mob_wins.wins FROM mob_wins, characters, mobs WHERE mob_wins.mob_id=".$arr['mob_id']." AND mobs.mob_id=".$arr['mob_id']." AND characters.player_id=mob_wins.player_id AND (characters.level<mobs.level+3 OR mobs.level>=15 OR (mobs.level>25 AND characters.clan_id=1)) ORDER BY wins DESC LIMIT 10");
	$ok = true;
	while (($arr1=f_MFetch($res1)) && $ok)
	{
		$ar_log = f_MValue("SELECT logout_time FROM history_logon_logout WHERE player_id=".$arr1[0]." ORDER BY entry_id DESC LIMIT 1");
		if (!$ar_log || ($ar_log+180*24*3600)>time())
		{
			$plr = new Player($arr1[0]);
			$plr->AddEffect(5, 0, $str1, $str2."<b>".$arr['name']."</b>", "longbow.png", "", $t+24*3600);
			$plr->AddMoney(1000);
			$plr->AddToLogPost(0, 1000, 995);
			$ok = false;
		}
	}
}

$str1 = iconv("UTF-8", "CP1251", "Лидер победителей турниров");
$str2 = iconv("UTF-8", "CP1251", "За максимальное число взятых 1 мест на турнирах");

$res = f_MQuery("SELECT champion, COUNT( * ) FROM tournament_results GROUP BY champion ORDER BY COUNT( * ) DESC , champion LIMIT 1");
$arr = f_MFetch($res);
$plr = new Player($arr[0]);
$plr->AddEffect(5, 0, $str1, $str2, "first.png", "501:-1.", $t+24*3600);

$str2 = iconv("UTF-8", "CP1251", "За максимальное число взятых 2 мест на турнирах");
$res = f_MQuery("SELECT second_place, COUNT( * ) FROM tournament_results GROUP BY second_place ORDER BY COUNT( * ) DESC , second_place LIMIT 1");
$arr = f_MFetch($res);
$plr = new Player($arr[0]);
$plr->AddEffect(5, 0, $str1, $str2, "second.png", "224:5.", $t+24*3600);

$str2 = iconv("UTF-8", "CP1251", "За максимальное число взятых 3 мест на турнирах");
$res = f_MQuery("SELECT third_place, COUNT( * ) FROM tournament_results GROUP BY third_place ORDER BY COUNT( * ) DESC , third_place LIMIT 1");
$arr = f_MFetch($res);
$plr = new Player($arr[0]);
$plr->AddEffect(5, 0, $str1, $str2, "third.png", "224:2.", $t+24*3600);

$str1 = iconv("UTF-8", "CP1251", "Лучший дуэлянт");
$str2 = iconv("UTF-8", "CP1251", "За максимальное число побед в боях против игроков");
$res = f_MQuery("SELECT player_id, pvp_w FROM player_statistics ORDER BY pvp_w DESC LIMIT 1");
$arr = f_MFetch($res);
$plr = new Player($arr[0]);
$plr->AddEffect(5, 0, $str1, $str2, "fight_winner.png", "101:".(25*$plr->level).".", $t+24*3600);

$str1 = iconv("UTF-8", "CP1251", "Худший дуэлянт");
$str2 = iconv("UTF-8", "CP1251", "За максимальное число поражений в боях против игроков");
$res = f_MQuery("SELECT player_id, pvp_l FROM player_statistics ORDER BY pvp_l DESC LIMIT 1");
$arr = f_MFetch($res);
$plr = new Player($arr[0]);
$plr->AddEffect(5, 0, $str1, $str2, "fight_luser.png", "101:-10.", $t+24*3600);

?>
