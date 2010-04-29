/*  ������� setHeight()
 *  ����������� ������ � ������
 *  ������������ ����� � ����������������  sidebar, 
 *  content � left_main_menu_bakground
 */
function setHeight() {
	var b1 = document.getElementById('sidebar');
	var b2 = document.getElementById('content');
	//var b3 = document.getElementById('left_main_menu_bakground');
	if (!b1 || !b2) return;
	var h1 = b1.offsetHeight;
	var h2 = b2.offsetHeight;
	if (h1 < h2) {
		b1.style.height = (h2) + 'px';
		//b2.style.height = (h2) + 'px';
		//b3.style.height = (h2 - h1 + 20) + 'px';
	}//else if (h1 > h2) {
//		b2.style.height = (h1 - 20) + 'px';
//	}
}

window.onload = setHeight;