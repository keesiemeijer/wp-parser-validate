	/**
	 * Creates links to jump to line number
	 */

	var lineNumbers = document.getElementsByClassName("line-number");
	var src, el, attrs;

	for (var i = 0, l = lineNumbers.length; i < l; i++) {
		src = lineNumbers[i];

		// Create link
		el = document.createElement('a');
		el.setAttribute('href', '#');

		// Add attributes to link
		attrs = src.attributes;
		for (var j = 0, k = attrs.length; j < k; j++) {
			el.setAttribute(attrs[j].name, attrs[j].value);
		}

		// Add line number text to link
		el.innerHTML = src.innerHTML;
		src.parentNode.replaceChild(el, src);

		// Add click event listener to link
		if (el.addEventListener) {
			el.addEventListener('click', clickEventCallback, false);
		} else {
			el.attachEvent('onclick', clickEventCallback);
		}
	}

	function clickEventCallback(event) {
		if (event.preventDefault) event.preventDefault();
		event.returnValue = false;

		var input = document.getElementById("code_content");
		var line = this.getAttribute('data-line-number');
		// scroll to textarea
        window.scroll(0,findPos(input));
        // Jump to line
		jumpToLine(input, line);
	}

	function jumpToLine(input, line) {

		var text = input.value;

		if( !text.length ) {
			return;
		}

		// Split text at newlines 
		var normalizedValue = text.replace(/\r\n/g, "\n");
		var text_arr = normalizedValue.split('\n');

		// Remove lines after line number
		text_arr = text_arr.slice(0, line);

		// Count characters of lines
		var total = 0;
		var last  = 0;
		var arr_length = text_arr.length;
		
		for (var i = 0; i < arr_length; i++) {
			total += text_arr[i].length + 1;
			if ( i === arr_length -1 ) {
				last = text_arr[i].length;
			}
		}

		total--;
		var start = total - last;

		// Set cursor at total of characters
		if (input.setSelectionRange) {
			input.focus();
			input.setSelectionRange(start, total);
		} else if (input.createTextRange) {
			var range = input.createTextRange();
			range.collapse(true);
			range.moveEnd('character', total);
			range.moveStart('character', start);
			range.select();
		}
	}

	function findPos(obj) {
    var curtop = 0;
    if (obj.offsetParent) {
        do {
            curtop += obj.offsetTop;
        } while (obj = obj.offsetParent);
    return [curtop];
    }
}