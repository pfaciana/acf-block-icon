(function ($, window, document, undefined) {

	function iconObject(icon) {
		if (typeof icon !== "string") {
			return icon;
		}

		try {
			icon = JSON.parse(icon);
		} catch (e) {
			return false;
		}

		return typeof icon === "object" && icon !== null ? icon : false;
	}

	function createElement(obj) {
		var args = [obj.element, obj.props], child;

		if (typeof args[1].style !== "undefined") {
			args[1].style = {'cssText': args[1].style}
		}

		if (typeof obj.children !== "undefined" && Array.isArray(obj.children) && obj.children.length > 0) {
			for (child in obj.children) {
				if (obj.children.hasOwnProperty(child)) {
					args.push(createElement(obj.children[child]));
				}
			}
		}

		return wp.element.createElement.apply(null, args);
	}

	function createIconElement(svg) {
		var props = {width: 24, height: 24};

		if (typeof svg !== "object" || svg === null) {
			return '';
		}

		if (typeof svg.props.fill !== "undefined") {
			svg.props.style = typeof svg.props.style === "undefined" ? 'fill:' + svg.props.fill : svg.props.style + ';fill:' + svg.props.fill;
		}

		svg.props = 'props' in svg ? $.extend(true, props, svg.props) : props;

		return createElement(svg);
	}

	if (typeof acf !== 'undefined' && 'data' in acf && acf.data.blockTypes) {
		acf.addAction('ready', function () {
			$.each(acf.data.blockTypes, function (i, block) {
				var iconSrc, icon = iconObject(block.icon);

				if (icon) {
					if (!('src' in icon)) {
						block.icon = createIconElement(icon);
					}
					else if (iconSrc = iconObject(icon.src)) {
						block.icon.src = createIconElement(iconSrc);
					}
				}
			});
		}, 1);
	}

}(jQuery, window, document));