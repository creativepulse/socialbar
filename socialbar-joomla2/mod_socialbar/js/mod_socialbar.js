
/**
 * social bar
 *
 * @version 1.1
 * @author Creative Pulse
 * @copyright Creative Pulse 2011-2013
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @link http://www.creativepulse.gr
 */


function Mod_SocialBar(params) {
    this.iname = params.iname;
    this.idx = params.idx;

    this.scroll_min_y = params.min_y;
    this.scroll_start_y = params.start_y - params.min_y;
    if (this.scroll_start_y < 0) {
        this.scroll_start_y = 0;
    }

    this.interval = 20;
    this.speed = 15;
    this.state = 1;

    this.wrapper_wdg = document.getElementById(this.iname);
    document.getElementsByTagName('body')[0].appendChild(this.wrapper_wdg);
    this.wrapper_wdg.style.position = "absolute";
    this.wrapper_wdg.style.display = "block";
    this.wrapper_wdg.style.left = "0px";

    this.cnt_wdg = document.getElementById(this.iname + "_cnt");
    this.cnt_wdg_maxh = this.cnt_wdg.offsetHeight;

    this.btn_wdg = document.getElementById(this.iname + "_btn_openclose");
    this.btn_wdg.setAttribute("iname", this.iname);
    this.btn_wdg.onclick = function () { document.mod_socialbar_inst[this.getAttribute("iname")].h_click(); }

    this.scroll_pos = 0; // 0 = not set, 1 = start, 2 = content

    this.h_scroll = function (top) {
        var pos = top > this.scroll_start_y ? 2 : 1;
        if (pos != this.scroll_pos) {
            if (pos == 1) {
                this.wrapper_wdg.style.position = "absolute";
                this.wrapper_wdg.style.top = (this.scroll_start_y + this.scroll_min_y) + "px";
            }
            else {
                this.wrapper_wdg.style.position = "fixed";
                this.wrapper_wdg.style.top = this.scroll_min_y + "px";
            }
            this.scroll_pos = pos;
        }
    }

    this.h_click = function () {
        if (this.state >= 1) {
            if (this.cnt_wdg_maxh < this.cnt_wdg.offsetHeight) {
                this.cnt_wdg_maxh = this.cnt_wdg.offsetHeight;
            }

            this.state = -1;
            this.btn_wdg.className = "mod_socialbar_btn_open";
        }
        else {
            this.state = 2;
            this.btn_wdg.className = "mod_socialbar_btn_close";
        }

        this.h_timer();
    }

    this.h_timer = function () {
        if (this.state == 2) {
            this.cnt_wdg.style.display = "block";

            var diff = Math.round((this.cnt_wdg_maxh - this.cnt_wdg.offsetHeight) * this.speed / 100);
            if (diff < 1) {
                diff = 1;
            }

            var val = this.cnt_wdg.offsetHeight + diff;
            this.cnt_wdg.style.height = val + "px";
            if (val >= this.cnt_wdg_maxh) {
                this.state = 1;
            }
        }
        else if (this.state == -1) {
            var diff = Math.round(this.cnt_wdg.offsetHeight * this.speed / 100);
            if (diff < 1) {
                diff = 1;
            }

            var val = this.cnt_wdg.offsetHeight - diff;
            this.cnt_wdg.style.height = val + "px";
            if (val <= 0) {
                this.cnt_wdg.style.display = "none";
                this.state = 0;
            }
        }

        if (this.state == 2 || this.state == -1) {
            setTimeout('document.mod_socialbar_inst["' + this.iname + '"].h_timer();', this.interval);
        }
    }
}


function mod_socialbar_scroll() {
    var top = 0;
    if (document.documentElement && document.documentElement.scrollTop) {
        top = document.documentElement.scrollTop;
    }
    else if (document.body && document.body.scrollTop) {
        top = document.body.scrollTop;
    }

    for (k in document.mod_socialbar_inst) {
        if (document.mod_socialbar_inst.hasOwnProperty(k)) {
            document.mod_socialbar_inst[k].h_scroll(top);
        }
    }
}

function mod_socialbar_init() {
    document.mod_socialbar_inst = {};

    if (document.mod_socialbar_conf) {
        for (k in document.mod_socialbar_conf) {
            if (document.mod_socialbar_conf.hasOwnProperty(k)) {
                document.mod_socialbar_inst[document.mod_socialbar_conf[k].iname] = new Mod_SocialBar(document.mod_socialbar_conf[k]);
            }
        }
    }
    mod_socialbar_scroll();
}


if (window.addEventListener) {
    window.addEventListener("load", mod_socialbar_init, false);
    window.addEventListener("scroll", mod_socialbar_scroll, false);
}
else if (window.attachEvent) {
    window.attachEvent("onload", mod_socialbar_init);
    window.attachEvent("onscroll", mod_socialbar_scroll);
}
