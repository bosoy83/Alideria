function screen_width( )
{
	if( self.innerWidth ) res = self.innerWidth;
	else res = document.body.clientWidth;
	return res;
}

function screen_height( )
{
	if( self.innerHeight ) res = self.innerHeight;
	else res = document.body.clientHeight;
	return res;
}


//document.write( "<div style='filter:progid:DXImageTransform.Microsoft.Alpha(opacity=85);-moz-opacity: 0.85;-khtml-opacity: 0.85;opacity: 0.85; z-index: 100; display: none; position: absolute;' id=tooltip>&nbsp;</div>" );
document.write( "<div style='z-index: 103; display: none; position: absolute;' id=tooltip>&nbsp;</div>" );

var tooltip_owner;
var tooltip_shown = 0;

function showTooltipW( e, a, wd )
{
	var x, y, sx, sy;

	sx = document.body.scrollLeft;
	sy = document.body.scrollTop;
	if( !document.all )
	{
		x = e.pageX;
		y = e.pageY;
	}
	else
	{
		x = window.event.clientX + document.body.scrollLeft;
		y = window.event.clientY + document.body.scrollTop;
	}

	s = "<table cellspacing=0 cellpadding=0 border=0";
	if( wd != 0 ) s += " width=" + wd;
	s += ">";
	s += "<tr>";

	s += "<td width=5 height=5 bgcolor=e0c3a0><img src=../../images/chat/chat_corner_0.gif width=5 height=5></td>";
				
	s += "<td height=5 background=../../images/chat/chat_border_top.gif bgcolor=e0c3a0></td>";
	s += "<td width=5 height=5 bgcolor=e0c3a0><img src=../../images/chat/chat_corner_1.gif width=5 height=5></td>";

	s += "</tr>";
	s += "<tr>";

	s += "<td width=5 background=../../images/chat/chat_border_left.gif bgcolor=e0c3a0></td>";
		
	s += "<td align=center valign=middle bgcolor=e0c3a0 background=../../images/chat/chat_bg.gif>";
	s += '<div id=tooltip_inner>' + a + '</div>';
	s += "</td>";
	s += "<td width=5 background=../../images/chat/chat_border_right.gif bgcolor=e0c3a0></td>";

	s += "</tr>";

	s += "<tr>";

	s += "<td width=5 height=5 bgcolor=e0c3a0><img src=../../images/chat/chat_corner_2.gif width=5 height=5></td>";
		
	
	s += "<td height=5 background=../../images/chat/chat_border_bottom.gif bgcolor=e0c3a0></td>";
	s += "<td width=5 height=5 bgcolor=e0c3a0><img src=../../images/chat/chat_corner_3.gif width=5 height=5></td>";
			
	s += "</tr>";
	s += "</table>";


	if( a !== false && ( !tooltip_shown || document.getElementById( 'tooltip' ).innerHTML != s ) )
	{
		document.getElementById( 'tooltip' ).innerHTML = s;
		document.getElementById( 'tooltip' ).style.display = '';
	}

	if( document.getElementById( 'tooltip' ).offsetWidth + x > screen_width( ) + sx - 35 ) x -= document.getElementById( 'tooltip' ).offsetWidth + 17;
	if( document.getElementById( 'tooltip' ).offsetHeight + y > screen_height( ) + sy - 35 ) y -= document.getElementById( 'tooltip' ).offsetHeight + 17;
	if( y < document.body.scrollTop ) y = document.body.scrollTop;

	document.getElementById( 'tooltip' ).style.left = ( parseInt( x ) + 15 ) + 'px';
	document.getElementById( 'tooltip' ).style.top = ( parseInt( y ) + 15 ) + 'px';
	document.getElementById( 'tooltip' ).style.zIndex = 103;

	
	tooltip_shown = 1;
}

function showTooltip( e, a )
{
	showTooltipW( e, a, 0 );
}

function hideTooltip( )
{
	document.getElementById( 'tooltip' ).style.display = 'none';
}
