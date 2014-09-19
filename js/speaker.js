// speaker.js
// This script either shows the local speaker form or the visiting speaker form.

$(function() {
		
if (document.getElementById('local_speaker').checked) {
        document.getElementById('pspeaker').style.visibility = 'visible';
    }
    else document.getElementById('pspeaker').style.visibility = 'hidden';
	
return false;

}); // End of document ready.