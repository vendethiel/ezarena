<?php
// Displays a calendar as a table
// Affiche un petit calendrier sous forme de tableau
// 
// Version: v2.1
// Copyright (c) 2005-2006 - Sylvain BAUDOIN
// Please, report all errors to webmaster@themanualpage.org
// Veuillez remonter toute erreur a webmaster@themanualpage.org
// 
// The PHP code of this page may be redistributed and/or modified according to
// the terms of the GNU General Public License, as it has been published by the
// Free Software Foundation (version 2 and above).
// This program is distributed in the hope that it will be useful but WITHOUT
// ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
// FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
// details.
// You should have received a copy of the GNU General Public License along with
// this program; if not, write to the Free Software Foundation, Inc.,
// 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
// 
// Ce programme PHP est un logiciel libre ; vous pouvez le redistribuer et/ou le
// modifier au titre des clauses de la Licence Publique Generale GNU, telle que
// publiee par la Free Software Foundation ; soit la version 2 de la Licence, ou
// (a votre discretion) une version ulterieure quelconque.
// Ce programme est distribue dans l'espoir qu'il sera utile, mais SANS AUCUNE
// GARANTIE ; sans meme une garantie implicite de COMMERCIABILITE ou DE
// CONFORMITE A UNE UTILISATION PARTICULIERE. Voir la Licence Publique Generale
// GNU pour plus de details.
// Vous devriez avoir recu un exemplaire de la Licence Publique Generale GNU
// avec ce programme ; si ce n'est pas le cas, ecrivez a la Free Software
// Foundation Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
// 
// 
// Usage:
// ------
// You integrate the calendar in a PHP page as follows:
// 
// ...
// require_once("calendar.php");
// ...
// $parameters = array("param1" => value1, "param2" => value2, ...);
// calendar($parameters);
// ...
// 
// Utilisation :
// -------------
// Le calendrier s'integre dans une page PHP en faisant :
// 
// ...
// require_once("calendar.php");
// ...
// $parametres = array("param1" => value1, "param2" => value2, ...);
// calendar($parametres);
// ...
// 
// Parameters:
// -----------
// "PREFIX":
//         prefix of the URL and session parameters of the calendar. Define a
//         different value for each different calendar to display along in the
//         same page. Do not start this prefix by a digit.
//         Default value: "calendar_".
// 
// "CSS_PREFIX":
//         prefix of the CSS classes used for styling the calendar. To be used
//         to render the calendars for different styles.
//         Default value: "calendar_".
// 
// "DATE_URL":
//         if set, indicates a URL to use for making the days clickable. This
//         URL is completed with the URL parameter indicated by the calendar
//         parameter "URL_PARAMETER".
//         Valeur par defaut : "".
// 
// "URL_PARAMETER":
//         if the previous parameter ("DATE_URL") is set, indicates the name of
//         the URL parameter used to complete the URL "DATE_URL" and pass the
//         clicked date. The date is formated according to the value of the
//         parameter URL_DAY_DATE_FORMAT for the days and URL_MONTH_DATE_FORMAT
//         for the month and year (title links).
//         Default value: "date".
// 
// "USE_SESSION":
//         set true to store the calendar rendering data in session. This allows
//         this script to remember the date to be displayed while browsing among
//         various pages.
//         Default value: false.
//         WARNING: if you want to use sessions, you must create the session
//         first at the very beginning of the page, because this script will not
//         do it.
// 
// "PRESERVE_URL":
//         when building the links for the "previous month" and "next month"
//         links, tells if current URL must be preserved (true) and the date
//         appended (?xx=yyy&...&date=...) or if the query string of the current
//         URL must be discarded (false) and just add the date parameter
//         (?date=...).
//         Default value: true.
// 
// "JS":
//         tells if the calendar is integrated as a JavaScript (true) or not.
//         Default value: false.
// 
// "JS_URL":
//         if the calendar is integrated as a JavaScript, this parameter gives
//         the URL of the page that integrates the calendar.
//         Default value: "".
// 
// "FIRST_WEEK_DAY":
//         first day of the week: 1 for Monday, 2 for Tuesday, etc..., 7 or
//         0 for Sunday.
//         Default value: 1 (Monday).
// 
// "LANGUAGE_CODE":
//         2-letter ISO code of the language to use for rendering the calendar.
//         Default value: "fr" (French).
// 
// "CLICKABLE_TITLE":
//         when DATE_URL is set, tells if the calendar title (i.e. the month +
//         year at the top of the calendar) is also clickable. In this case, the
//         date passed in the URL parameter has the format indicated by the
//         parameter URL_MONTH_DATE_FORMAT.
//         Default value: true.
// 
// "OUTPUT_MODE":
//         if set to "return", will make the function Calendar return the HTML
//         code of the calendar. If set to "echo", the HTML code of the calendar
//         is directly echoed into the response to the web browser. Use "return"
//         if you want to get the HTML code of the calendar into a PHP variable
//         and make some processing on it.
//         Default value: "echo".
// 
// "URL_DAY_DATE_FORMAT":
//         when DATE_URL is defined, tells the format of the calendar day dates
//         passed in the URL. This format must comply with the format supported
//         by the PHP function date. Has no effect if DATE_URL is not defined.
//         Default value: "dmY" (ddmmyyyy).
// 
// "URL_MONTH_DATE_FORMAT":
//         when DATE_URL is defined, tells the format of the month date passed
//         in the URL for the calendar's title. This format must comply with
//         the format supported by the PHP function date. Has no effect if
//         DATE_URL is not defined.
//         Valeur par defaut : "mY" (mmyyyy).
// 
// Parametres :
// ------------
// "PREFIX" :
//         prefixe des parametres d'URL et de session du calendrier. Definissez
//         une valeur differente pour chaque calendrier a afficher sur la meme
//         page. Ne pas commencer le prefixe par un chiffre.
//         Valeur par defaut : "calendar_".
// 
// "CSS_PREFIX" :
//         prefixe des classes CSS utilisees pour le style du calendrier. A
//         utiliser pour afficher des calendriers dans differents styles.
//         Valeur par defaut : "calendar_".
// 
// "DATE_URL" :
//         si defini, indique une URL a utiliser pour rendre les jours du
//         calendrier cliquables. Cette URL est completee par le parametre d'URL
//         indique par le parametre "URL_PARAMETER" du calendrier.
//         Valeur par defaut : "".
// 
// "URL_PARAMETER" :
//         si le parametre precedent ("DATE_URL") est defini, indique le nom du
//         parametre d'URL a utiliser pour completer l'URL "DATE_URL" avec la
//         date cliquee. La date est passée au format indiqué par le parametre
//         URL_DAY_DATE_FORMAT pour les jours et URL_MONTH_DATE_FORMAT pour le
//         mois et l'annee (lien du titre du calendrier).
//         Valeur par defaut : "date".
// 
// "USE_SESSION" :
//         mettre a true pour stocker les donnees d'affichage du calendrier en
//         session. Cela permet de memoriser l'affichage lorsqu'on navigue
//         entre plusieurs pages.
//         Valeur par defaut : false (faux).
//         ATTENTION : si vous utilisez les sessions, n'oubliez pas de creer la
//         session au tout debut de votre script, ce script ne le fera pas.
// 
// "PRESERVE_URL" :
//         indique, au moment de constuire les URL des liens "mois precedent"
//         et "mois suivant", s'il faut conserver (true) l'URL actuelle de la
//         page et ajouter la date (?xx=yyy&...&date=...) ou s'il faut supprimer
//         la query string et ne mettre que le parametre de date (?date=...).
//         Valeur par defaut : true (vrai).
// 
// "JS" :
//         indique si le calendrier est integre en JavaScript (true) ou non.
//         Valeur par defaut : false (faux).
// 
// "JS_URL" :
//         si l'integration JavaScript est utilisee, doit indiquer l'URL de la
//         page integrant le calendrier.
//         Valeur par defaut : "".
// 
// "FIRST_WEEK_DAY" :
//         premier jour de la semaine : 1 pour lundi, 2 pour mardi, etc..., 7 ou
//         0 pour dimanche.
//         Valeur par defaut : 1 (lundi).
// 
// "LANGUAGE_CODE" :
//         code ISO a 2 lettres de la langue d'affichage du calendrier.
//         Valeur par defaut : "fr" (francais).
// 
// "CLICKABLE_TITLE" :
//         lorsque DATE_URL est defini, dit si le titre du calendrier (i.e. le
//         mois + annee en haut du calendrier) est cliquable. Dans ce cas, la
//         date passee dans le parametre d'URL est au format indique par le
//         parametre URL_MONTH_DATE_FORMAT.
//         Valeur par defaut : true (vrai).
// 
// "OUTPUT_MODE" :
//         si defini a "return", le code HTML du calendrier sera renvoye en tant
//         que valeur de retour de la fonction Calendar. Si defini a "echo", le
//         code HTML du calendrier sera directement renvoye dans la reponse au
//         navigateur. Utilisez "return" si vous voulez recuperer le code HTML
//         du calendrier dans une variable PHP et eventuellement faire des
//         traitements dessus.
//         Valeur par defaut : "echo".
// 
// "URL_DAY_DATE_FORMAT" :
//         lorsque DATE_URL est defini, indique le format de la date des jours
//         du calendrier passee dans l'URL. Ce format doit etre donne selon le
//         format supporte par la fonction PHP date. Sans effet si DATE_URL
//         n'est pas defini.
//         Valeur par defaut : "dmY" (jjmmaaaa).
// 
// "URL_MONTH_DATE_FORMAT" :
//         lorsque DATE_URL est defini, indique le format de la date du mois
//         passee dans l'URL (lien du titre du calendrier). Ce format doit etre
//         donne selon le format supporte par la fonction PHP date. Sans effet
//         si DATE_URL n'est pas defini.
//         Valeur par defaut : "mY" (mmaaaa).
// 
function Calendar($params) {
	// 
	// VARIABLES
	// 
	
	// Global variables 
	global $_SESSION;
	global $_SERVER;
	global $_GET;
	
	// Calendar parameters with default values
	$PREFIX                = "calendar_";
	$CSS_PREFIX            = "calendar_";
	$DATE_URL              = "";
	$URL_PARAMETER         = "date";
	$USE_SESSION           = false;
	$PRESERVE_URL          = true;
	$JS                    = false;
	$JS_URL                = "";
	$FIRST_WEEK_DAY        = 1;
	$LANGUAGE_CODE         = "fr";
	$CLICKABLE_TITLE       = true;
	$OUTPUT_MODE           = "echo";
	$URL_DAY_DATE_FORMAT   = "dmY";
	$URL_MONTH_DATE_FORMAT = "mY";
	
	// Will contains the complete HTML code of the calendar in the case the
	// output mode is set to "return"
	$CALENDAR_RESPONSE = "";
	
	// Overwrite parameters with custom values
	extract($params);
	
	// Translations for month and day
	include("calendar_locales.php");
	// Month names
	if (isset($MONTHS[$LANGUAGE_CODE])) {
		$month_name = $MONTHS[$LANGUAGE_CODE];
	} else {
		$month_name = $MONTHS["fr"];
	}
	// Short names of days
	if (isset($WEEK_DAYS[$LANGUAGE_CODE])) {
		$day_name = $WEEK_DAYS[$LANGUAGE_CODE];
	} else {
		$day_name = $WEEK_DAYS["fr"];
	}
	// Current month's name
	if (isset($MONTH_HEADER[$LANGUAGE_CODE])) {
		$month_header = $MONTH_HEADER[$LANGUAGE_CODE];
	} else {
		$month_header = $MONTH_HEADER["fr"];
	}
	
	
	// 
	// FUNCTIONS
	// 
	
	// This function displays HTML code: if $JS = true, we do not display line
	// breaks
	if (! function_exists("calendar_display")) {
		function calendar_display($text, $JS, &$CALENDAR_RESPONSE) {
			if ($JS) {
				// We escape all ' of the text
				$CALENDAR_RESPONSE .= "document.writeln('".str_replace("'", "\\'", $text)."');\n";
			} else {
				$CALENDAR_RESPONSE .= $text."\n";
			}
		}
	}
	
	// This function sets the calendar URL parameter $URL_PARAMETER to $date in
	// the given URL $URL. Used for the previous and next arrows of the calendar
	// title and the calendar dates when set as clickable with the parameter
	// DATE_URL.
	if (! function_exists("calendar_calculate_URL")) {
		function calendar_calculate_URL($URL, $URL_PARAMETER, $date, $PRESERVE_URL, $USE_SESSION) {
			$URL_components = parse_url($URL);
			$new_URL        = $URL_components["path"]."?";
			$add_SID        = $USE_SESSION;
			// We retrieve and preserve the current URL parameters if required
			if ($PRESERVE_URL && isset($URL_components["query"])) {
				parse_str($URL_components["query"], $query_string);
				// We build the query string
				foreach ($query_string as $param => $value) {
					if ($param != $URL_PARAMETER) {
						$new_URL .= $param."=".urlencode($value)."&amp;";
					}
					// If the SID is already there, we do not add it again
					if ($USE_SESSION && $param == session_name()) {
						$add_SID = false;
					}
				}
			}
			
			// We add the date
			$new_URL .= $URL_PARAMETER."=".$date;
			
			// We also add the session ID (SID) if necessary
			if ($add_SID && SID != "") {
				$new_URL .= "&amp;".SID;
			}
			
			return $new_URL;
		}
	}
	
	// This function calculates the date of the previous month with the mmyyyy
	// format
	if (! function_exists("calendar_previous_month")) {
		function calendar_previous_month($month, $year) {
			if ($month == 1) {
				$new_month = "12";
				$new_year  = $year - 1;
			} else {
				$new_month = (($month > 10)?"":"0").($month - 1);
				$new_year  = $year;
			}
			
			return $new_month.$new_year;
		}
	}
	
	// This function calculates the date of the next month with the mmyyyy format
	if (! function_exists("calendar_next_month")) {
		function calendar_next_month($month, $year) {
			if ($month == 12) {
				$new_month = "01";
				$new_year  = $year + 1;
			} else {
				$new_month = (($month < 9)?"0":"").($month + 1);
				$new_year  = $year;
			}
			
			return $new_month.$new_year;
		}
	}
	
	// 
	// MAIN LOOP
	// 
	
	// Today's date
	$today = date("dmY");
	
	// Month and year to display (gotten from URL)
	if (isset($_GET[$PREFIX."date"])) {
		if ($_GET[$PREFIX."date"] != "") {
			$month = (int)substr($_GET[$PREFIX."date"], 0, 2);
			$year  = substr($_GET[$PREFIX."date"], 2);
		}
	}
	
	// Default month to show (if not found in the URL)
	if (!isset($month)) {
		$month = date("n");
		// In the case of session, we must get the session date
		if ($USE_SESSION && isset($_SESSION[$PREFIX."month"])) {
			$month = $_SESSION[$PREFIX."month"];
		}
	}
	// We put the month in the session if required
	if ($USE_SESSION) {
		$_SESSION[$PREFIX."month"] = $month;
	}
	
	// Default year to show (if not found in the URL)
	if (!isset($year)) {
		$year = date("Y");
		// In the case of session, we must get the session date
		if ($USE_SESSION && isset($_SESSION[$PREFIX."year"])) {
			$year = $_SESSION[$PREFIX."year"];
		}
	}
	// We put the year in the session if required
	if ($USE_SESSION) {
		$_SESSION[$PREFIX."year"] = $year;
	}
	
	// We display the top of the calendar
	if ($JS) {
		$URL_page = $JS_URL;
	} else {
		$URL_page = $_SERVER["REQUEST_URI"];
	}
	calendar_display("<table class=\"".$CSS_PREFIX."main\" summary=\"\">", $JS, $CALENDAR_RESPONSE);
	calendar_display("	<tr class=\"".$CSS_PREFIX."title\">", $JS, $CALENDAR_RESPONSE);
	calendar_display("		<td class=\"".$CSS_PREFIX."title_left_arrow\"><a href=\"".calendar_calculate_URL($URL_page, $PREFIX."date", calendar_previous_month($month, $year), $PRESERVE_URL, $USE_SESSION)."\" class=\"".$CSS_PREFIX."title_left_arrow_clickable\">&lt;&lt;</a></td>", $JS, $CALENDAR_RESPONSE);
	if ($DATE_URL != "" && $CLICKABLE_TITLE) {
		calendar_display("		<td class=\"".$CSS_PREFIX."title_month\"><a href=\"".calendar_calculate_URL($DATE_URL, $URL_PARAMETER, date($URL_MONTH_DATE_FORMAT, mktime(0, 0, 0, $month, 1, $year)), true, $USE_SESSION)."\" class=\"".$CSS_PREFIX."title_month_clickable\">".str_replace("%y", $year, str_replace("%m", $month_name[$month - 1], $month_header))."</a></td>", $JS, $CALENDAR_RESPONSE);
	} else {
		calendar_display("		<td class=\"".$CSS_PREFIX."title_month\">".str_replace("%y", $year, str_replace("%m", $month_name[$month - 1], $month_header))."</td>", $JS, $CALENDAR_RESPONSE);
	}
	calendar_display("		<td class=\"".$CSS_PREFIX."title_right_arrow\"><a href=\"".calendar_calculate_URL($URL_page, $PREFIX."date", calendar_next_month($month, $year), $PRESERVE_URL, $USE_SESSION)."\" class=\"".$CSS_PREFIX."title_right_arrow_clickable\">&gt;&gt;</a></td>", $JS, $CALENDAR_RESPONSE);
	calendar_display("	</tr>", $JS, $CALENDAR_RESPONSE);
	calendar_display("	<tr>", $JS, $CALENDAR_RESPONSE);
	calendar_display("		<td colspan=\"3\">", $JS, $CALENDAR_RESPONSE);
	calendar_display("			<table class=\"".$CSS_PREFIX."table\" summary=\"\">", $JS, $CALENDAR_RESPONSE);
	calendar_display("				<tr>", $JS, $CALENDAR_RESPONSE);
	for ($counter = 0; $counter < 7; $counter++) {
		calendar_display("					<th>".$day_name[($FIRST_WEEK_DAY + $counter) % 7]."</th>", $JS, $CALENDAR_RESPONSE);
	}
	calendar_display("				</tr>", $JS, $CALENDAR_RESPONSE);
	
	// We calculate the first day of the month to show
	$first_month_day = gmmktime(0, 0, 0, $month, 1, $year);
	
	// We calculate the week day of this first day so that we can determine how
	// many days we are far from the first week day
	$offset = (7 - ($FIRST_WEEK_DAY % 7 - gmdate("w", $first_month_day))) % 7;
	
	// First day of the calendar
	$current_day = $first_month_day - 3600 * 24 * $offset;
	
	// We are going to display a table => 2 nested loops
	// How many rows in the calendar?
	$row_number = ceil((gmdate("t", $first_month_day) + $offset) / 7);
	for ($row = 1; $row <= $row_number; $row++) {
		// The first loop displays the rows
		calendar_display("				<tr>", $JS, $CALENDAR_RESPONSE);
		
		// The second loop displays the days (as columns)
		for ($column = 1; $column <= 7; $column++) {
			// Day currently displayed
			$day = gmdate("j", $current_day);
			
			// If it is saturday or sunday, we use the "weekend" style
			if (gmdate("w", $current_day) == 6 || gmdate("w", $current_day) == 0) {
				$table_cell = "					<td class=\"".$CSS_PREFIX."weekend\">";
			} else {
				$table_cell = "					<td>";
			}
			
			// We display the current day
			$CSS_class = "";
			// Clickable days?
			if ($DATE_URL != "") {
				if (gmdate("dmY", $current_day) == $today) {
					$CSS_class = $CSS_PREFIX."today_clickable";
				} else {
					// Days not in the current month with CSS class "other_month"
					if (gmdate("n", $current_day) != $month) {
						$CSS_class = $CSS_PREFIX."other_month_clickable";
					} else {
						$CSS_class = $CSS_PREFIX."day_clickable";
					}
				}
				$table_cell .= "<a href=\"".calendar_calculate_URL($DATE_URL, $URL_PARAMETER, gmdate($URL_DAY_DATE_FORMAT, $current_day), true, $USE_SESSION)."\" class=\"".$CSS_class."\">".$day."</a>";
			} else {
				// Days not in the current month with CSS class "other_month"
				if (gmdate("n", $current_day) != $month) {
					$CSS_class = $CSS_PREFIX."other_month";
				}
				// If we are displaying today's day, CSS class "today"
				if (gmdate("dmY", $current_day) == $today) {
					$CSS_class = $CSS_PREFIX."today";
				}
				if ($CSS_class == "") {
					$table_cell .= $day;
				} else {
					$table_cell .= "<span class=\"".$CSS_class."\">".$day."</span>";
				}
			}
			
			// End of day cell
			calendar_display($table_cell."</td>", $JS, $CALENDAR_RESPONSE);
			
			// Next day
			$current_day += 3600 * 24 + 1;
		}
		
		// End of rows
		calendar_display("				</tr>", $JS, $CALENDAR_RESPONSE);
	}
	
	calendar_display("			</table>", $JS, $CALENDAR_RESPONSE);
	calendar_display("		</td>", $JS, $CALENDAR_RESPONSE);
	calendar_display("	</tr>", $JS, $CALENDAR_RESPONSE);
	
	// Display a link to the current date at the bottom of the calendar
	calendar_display("	<tr class=\"".$CSS_PREFIX."footer\">", $JS, $CALENDAR_RESPONSE);
	// We change the CSS class according to the month being displayed
	if ($month.$year == date("nY")) {
		calendar_display("		<td colspan=\"3\" class=\"".$CSS_PREFIX."footer_current_month\"><a href=\"".calendar_calculate_URL($URL_page, $PREFIX."date", date("mY"), $PRESERVE_URL, $USE_SESSION)."\" class=\"".$CSS_PREFIX."footer_current_month_clickable\">".$CALLBACK[$LANGUAGE_CODE]."</a></td>", $JS, $CALENDAR_RESPONSE);
	} else {
		calendar_display("		<td colspan=\"3\" class=\"".$CSS_PREFIX."footer_other_month\"><a href=\"".calendar_calculate_URL($URL_page, $PREFIX."date", date("mY"), $PRESERVE_URL, $USE_SESSION)."\" class=\"".$CSS_PREFIX."footer_other_month_clickable\">".$CALLBACK[$LANGUAGE_CODE]."</a></td>", $JS, $CALENDAR_RESPONSE);
	}
	calendar_display("	</tr>", $JS, $CALENDAR_RESPONSE);
	
	calendar_display("</table>", $JS, $CALENDAR_RESPONSE);
	
	// Return the HTML code?
	if ($OUTPUT_MODE == "return") {
		return $CALENDAR_RESPONSE;
	} else {
		echo $CALENDAR_RESPONSE;
	}
}
?>
