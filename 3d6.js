/*
 *  This file is part of 3d6.com.ar.

 *  3d6.com.ar is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.

 *  3d6.com.ar is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.

 *  You should have received a copy of the GNU Affero General Public
 *  License along with 3d6.com.ar.  If not, see
 *  <http://www.gnu.org/licenses/>.
 */

$(function () {
	$("#rolls").focus();
	var form = $("#rollform");

	if (form.attr("action") === "newroll.php") {
		form.submit(function () {
			$("#submit").attr('disabled','disabled');
			$.ajax({
				async: false,
				url: "new",
				success: function (url) {
				         	form.attr("action", "rolls/" + url);
				         }
			});
			$("#submit").removeAttr('disabled');
			return true;
		});
	} else {
		function format(roll) {
			var li = $("<li></li>");

			if (roll["name"] != undefined) {
				li.append($("<h2>" + roll["name"] + "</h2>"));
			}

			var count = 0;
			var detail = "";
			for each (var die in roll["rolls"]) {
				if (die["count"] != undefined) {
					if (die["count"] < 0) {
						detail += " - ";
					} else if (count > 0) {
						detail += " + ";
					}

					detail += " [";

					var len = die["detail"].length;
					for (var i = 0; i < len; i++) {
						detail += "<span" + (die['detail'][i]['chosen'] ? ' class="selected"' : '') + '>';
						detail += die["detail"][i][0];
						detail += "</span>";

						if (i < (len - 1)) {
							detail += ", ";
						}
					}

					detail += "]";
				} else {
					if (die < 0) {
						detail += " - ";
					} else if (count > 0) {
						detail += " + ";
					}

					detail += Math.abs(die);
				}

				count++;
			}

			li.append($("<p>" + roll["text"] + " = " + roll["total"] + ": " + detail + "</p>"));

			return li;
		}

		var spinner = $("<img id='spinner' src='/spinner.gif' />")
			.bind("ajaxSend", function () {
				$(this).show();
			})
			.bind("ajaxComplete", function () {
				$(this).hide();
			});

		$("#submit")
			.after(spinner)
			.bind("ajaxSend", function () {
				$(this).attr('disabled','disabled');
			})
			.bind("ajaxComplete", function () {
				$(this).removeAttr('disabled');
			});

		spinner.hide();
		
		form.submit(function () {
			$.post('/partialroll.php',
				{
					'url': $("#url").attr('value'),
					'count': $("#count").attr('value'),
					'verification': $("#verification").attr('value'),
					'rolls': $("#rolls").attr('value')
				},
				function (data) {
					$("#count").attr('value', data['count']);
					$("#verification").attr('value', data['verification']);

					var resultlist = $("#rollresults");
					for each (var roll in data['rolls']) {
						var result = format(roll);
						resultlist.prepend(result);
						result.hide().show(200);
					}
				},
				"json");

			return false;
		});
	}
});
