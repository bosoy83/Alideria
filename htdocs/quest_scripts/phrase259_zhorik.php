<?

if( !$mid_php ) die( );

if ( $player->HasTrigger( 101 ) )
{
	// ok, ��� ��� ����� ����. �����, �� ������ ��� ������� �����
	echo "<b>�����</b>: �� �������� �������... ������ ���� �������.<br>";
	$item_id = $player->GetQuestValue( 105 );
	$arr = f_MFetch( f_MQuery( "SELECT name FROM items WHERE item_id={$item_id}" ) );
	if ( !$arr )
		RaiseError( "����� {$player->login} ������� � ������� �� ������� ����������� ������� {$item_id}" );
	echo "�� ���������: <a href=help.php?id=1010&item_id=$item_id target=_blank>{$arr[0]}</a>.";
//		$player->AddItems( $item_id );
// �� ���� �������� ������
	echo "<br><br><ul><li><a href='game.php?phrase=610'>�������</a></ul>";
	return;
}

require_once( 'zhorik_quest_add.php' );

$current_task = $player->GetQuestValue( 102 );
$deadline = $player->GetQuestValue( 101 );

if( $deadline > time( ) ) //have quest for this day
{
	if ( $player->HasTrigger( 102 ) )
	{
		$player->SetTrigger( 101 );
		echo "<b>�����</b>: �� �������� �������... ������ ���� �������.<br>";
		$item_id = $player->GetQuestValue( 105 );
		$arr = f_MFetch( f_MQuery( "SELECT name FROM items WHERE item_id={$item_id}" ) );
		if ( !$arr )
			RaiseError( "����� {$player->login} ������� � ������� �� ������� ����������� ������� {$item_id}" );
		echo "�� ���������: <a href=help.php?id=1010&item_id=$item_id target=_blank>{$arr[0]}</a>.";
		$player->AddItems( $item_id );
		$player->AddToLogPost( $item_id, 1, 990);
		echo "<br><br><ul><li><a href='game.php?phrase=610'>�������</a></ul>";
	}
	else
	{
		echo "<b>�����</b>: ���� ������� �������: <b>" . get_current_task_text( $current_task ) . "</b>. ��� ��������� � �������, � ������ ��� ����� �� ���������� �� ����� ��������� ������.<br><br><ul>";
		echo "<li><a href='game.php?phrase=608'>� " . ($player->sex?"������":"�����") . " � ����������� �� ����� �������. ������, ��������, �������� ����a...</a>";
		echo "<li><a href='game.php?phrase=610'>�����, � �������</a></ul>";
	}
	return;
}

echo "<div style='text-align:left'>";//<img width=163 height=165 src='images/npcs/favn.jpg' hspace=5 vspace=5 align=left>";
echo "<i>����� ����������, �������. ���� �� �����, ���� ��������������� � ��� ������������ �� �����-�� ��� �� ����. ��, ������, �� ������� ��� ��������: ����������� �� ��� �� ������.</i><br>";
$play_cost = 10 * $player->level;
echo "<br><b>�����</b>: �����, �����, �����... ����� ����� ������� �����, ������. ��, ���� ������ ���������� ������� �����. ���� � ���� ������������� �������, �������� �� �� ������ ��������: �� �������� ���� ������� ������� ($play_cost), ��������� �� ��� ���� �������, � ����� ����������, �� ��������� ���� �������. ����������, ������ ��������. ������������, �� �� ����� �� ��� � ��� � ���� ������ ������� ����� ��������������� ��� ������ ������������. � �����, ���� ������ � ������ �����, ������ ���������, �-�� ��������� ������ ��� �������� �� ��� ��������.";

echo "</div>";


$first_prize_filename="images/items/res/ore_iron.gif";

echo "<table><tr><td><br><br>
<div id=field style='position:relative;left:0px;top:0px;'>

<img width='270px' height='190px' border=0 src='images/misc/bandit_field.jpg'>

<div style='position:absolute;left:50px;top:70px;'><img id=roll0 src='$first_prize_filename' width=50 height=50></div>
<div style='position:absolute;left:112px;top:70px;'><img id=roll1 src='$first_prize_filename' width=50 height=50></div>
<div style='position:absolute;left:173px;top:70px;'><img id=roll2 src='$first_prize_filename' width=50 height=50></div>

</div>
";

echo "</td><td valign=top><br><br>";
echo "<div id=talkmenu><ul>";
echo "<li><a href='' onClick='return start_roll( )'>�������</a>";
echo "<li><a href='game.php?phrase=610'>����</a>";
echo "</ul></div></td></tr></table>";

?>
<script>
	function draw_r( id, src, alt )
	{
		_( 'roll' + id ).alt = alt;
		_( 'roll' + id ).src = eval( src );
	}
	function talk_out( vtext )
	{
		_( 'talkmenu' ).innerHTML = vtext;
	}
	function start_roll( )
	{
		query( 'quest_scripts/phrase259_ajax.php', '' );
		return false;
	}
</script>