/* ======================================================
*  Javascrip helpers
*  =====================================================*/

/**
 * Save a cookie in the browser
 * @param {string} name
 * @param {string} value
 * @param {integer} days
 */
function createCookie(name,value,days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        expires = '; expires='+date.toGMTString();
    } else {
    	expires = '';
    }
    document.cookie = name+'='+value+expires+'; path=/';
}

/**
 * Returns the value of a cookie
 * @param {string} name
 * @return {string | boolean}
 */
function readCookie(name) {
    var n = name + '=';
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)===' ') {
        	c = c.substring(1,c.length);
        }
        if (c.indexOf(n) === 0) {
        	return c.substring(n.length,c.length);
        }
    }
    return false;
}

/**
 * Deletes a cookie
 * @param {string} name
 */
function eraseCookie(name) {
    createCookie(name,'',-1);
}
