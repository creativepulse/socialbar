
/**
 * Social Bar
 *
 * @version 1.2
 * @author Creative Pulse
 * @copyright Creative Pulse 2011-2014
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @link http://www.creativepulse.gr
 */


function CpWdgJs_SocialBar(params) {
	this.iname = params.iname;

	this.scroll_min_y = params.min_y;
	this.scroll_start_y = params.start_y - params.min_y;
	if (this.scroll_start_y < 0) {
		this.scroll_start_y = 0;
	}

	this.$wdg = $("#" + this.iname).appendTo($("body")).css({position: "absolute", display: "block"});

	this.pos_x_list = [];
	var pos_x_e1 = params.pos_x.split("|");
	for (var i = 0, len = pos_x_e1.length; i < len; i++) {
		var pos_x_e2 = pos_x_e1[i].split(":");
		if (pos_x_e2.length == 2) {
			pos_x_e2[0] = pos_x_e2[0].replace(/^\s+|\s+$/g, "");
			pos_x_e2[1] = pos_x_e2[1].replace(/^\s+|\s+$/g, "");
			if (pos_x_e2[0] != "" && pos_x_e2[1] != "") {
				this.pos_x_list.push({selector: pos_x_e2[0], x: parseInt(pos_x_e2[1], 10)});
			}
		}
	}

	this.on_scroll = function (top) {
		var pos = top > this.scroll_start_y ? 2 : 1;
		if (pos != this.scroll_pos) {
			if (pos == 1) {
				this.$wdg.css({position: "absolute", top: (this.scroll_start_y + this.scroll_min_y) + "px"});
			}
			else {
				this.$wdg.css({position: "fixed", top: this.scroll_min_y + "px"});
			}
			this.scroll_pos = pos;
		}
	}
	this.scroll_pos = 0; // 0 = not set, 1 = start, 2 = content
	this.on_scroll($(window).scrollTop());

	this.on_resize = function () {
		this.$wdg.css({left: 0});
		for (var i = 0, len = this.pos_x_list.length; i < len; i++) {
			var $obj = $(this.pos_x_list[i].selector);
			if ($obj.length > 0) {
				var offset = $obj.offset();
				var left = offset.left + this.pos_x_list[i].x;
				left = this.pos_x_list[i].x >= 0 ? left + $obj.outerWidth() : left - this.$wdg.outerWidth();

				if (left + this.$wdg.outerWidth() > $(window).outerWidth()) {
					left = $(window).outerWidth() - this.$wdg.outerWidth();
				}

				if (left < 0) {
					left = 0;
				}

				this.$wdg.css({left: left});
				return;
			}
		}
	}
	this.on_resize();
}

$(document).ready(function () {
	if (document.cpwdg_socialbar_conf) {
		document.cpwdg_socialbar_inst = {};

		for (k in document.cpwdg_socialbar_conf) {
			if (document.cpwdg_socialbar_conf.hasOwnProperty(k)) {
				document.cpwdg_socialbar_inst[document.cpwdg_socialbar_conf[k].iname] = new CpWdgJs_SocialBar(document.cpwdg_socialbar_conf[k]);
			}
		}

		$(window).scroll(function () {
			var top = $(window).scrollTop();
			for (k in document.cpwdg_socialbar_inst) {
				if (document.cpwdg_socialbar_inst.hasOwnProperty(k)) {
					document.cpwdg_socialbar_inst[k].on_scroll(top);
				}
			}
		});

		$(window).resize(function () {
			for (k in document.cpwdg_socialbar_inst) {
				if (document.cpwdg_socialbar_inst.hasOwnProperty(k)) {
					document.cpwdg_socialbar_inst[k].on_resize();
				}
			}
		});
	}
});
