<?php
//创建一个日期类
class Calendar
{
	var $startDay=0;
	var $startMonth=1;
	var $dayNames=array("<font color='red' face='courier new'>Sunday</font>",
	 					 "<font color='green' face='courier new'>Monday",
	 					 "<font color='green' face='courier new'>Tuesday",
						 "<font color='green' face='courier new'>Wednesday",
						 "<font color='green' face='courier new'>Thursday",
 						 "<font color='green' face='courier new'>Friday",
						 "<font color='red' face='courier new'>Saturday");
    var $monthNames=array("<font color='maroon' size=4 face='courier new'><b>January</b></font>",
	                        "<font color='maroon' size=4 face='courier new'><b>February</b></font>",
							"<font color='maroon' size=4 face='courier new'><b>March</b></font>",
							"<font color='maroon' size=4 face='courier new'><b>April</b></font>",
							"<font color='maroon' size=4 face='courier new'><b>May</b></font>",
							"<font color='maroon' size=4 face='courier new'><b>June</b></font>",
                            "<font color='maroon' size=4 face='courier new'><b>July</b></font>",
							"<font color='maroon' size=4 face='courier new'><b>August</b></font>",
							"<font color='maroon' size=4 face='courier new'><b>September</b></font>",
							"<font color='maroon' size=4 face='courier new'><b>October</b></font>",
							"<font color='maroon' size=4 face='courier new'><b>November</b></font>",
							"<font color='maroon' size=4 face='courier new'><b>December</b></font>");
    var $daysInMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

	function setDayNames($names)
	{
		$this->dayNames=$names;
	}
	function getDayNames()
	{
		return $this->dayNames;
	}
	function setMonthNames($names)
	{
		$this->monthNames=$names;
	}
	function getMonthNames()
	{
		return $this->monthNames;
	}

	function setStartDay($day)
	{
		$this->startDay=$day;
	}
	//获取一个开始日期的函数
	function getStartDay()
	{
		return $this->startDay;
	}
	function setStartMonth($month)
	{
		$this->startMonth=$month;
	}
	function getStartMonth()
	{
		return $this->startMonth;
	}

	function getCalendarLink($month,$year)
	{
		return "";
	}

	//声明一个获取日期链接的函数
	function getDateLink($day,$month,$year)
	{
		$link="counter.php?day=$day&month=$month&year=$year&fromcounter=1";
		return "$link";
	}
	//设置日期链接
	function getCurrentMonthView()
	{
		$d=getdate(time());
		return $this->getMonthView($d["mon"],$d["year"]);
	}
	//获取当前年份
	function getCurrentYearView()
	{
		$d=getdate(time());
		return $this->getYearView($d["year"]);
	}
	//声明一个获取指定年，月的函数
	function getMonthView($month,$year)
	{
		return $this->getMonthHTML($month,$year);
	}
	//声明一个获取指定年的月份信息的函数
	function getYearView($year)
	{
		return $this->getYearHTML($year);
	}
	//获取每月的天数
	function getDaysInMonth($month,$year)
	{
		if($month<1 || $month>12)
		{
			return 0;
		}
		$d=$this->daysInMonth[$month-1];
		if($month==2)
		{
			if($year%4==0)
			{
				if($year%100==0)
				{
					if($year%400==0)
					{
						$d=29;
					}
				}
				else
				{
					$d=29;
				}
			}
		}
		return $d;
	}
	//声明一个获取月份的getMonthHTML函数
	function getMonthHTML($m,$y,$showYear=1)
	{
		$s="";
		$a=$this->adjustDate($m,$y);
		$month=$a[0];
		$year=$a[1];
		$daysInMonth=$this->getDaysInMonth($month,$year);
		$date=getdate(mktime(12,0,0,$month,1,$year));
		$first=$date['wday'];
		$monthName=$this->monthNames[$month-1];
		$prev=$this->adjustDate($month-1,$year);
		$next=$this->adjustDate($month+1,$year);
		if($showYear==1)
		{
			$prevMonth=$this->getCalendarLink($prev[0],$prev[1]);
			$nextMonth=$this->getCalendarLink($next[0],$next[1]);
		}
		else
		{
			$prevMonth="";
			$nextMonth="";
		}

		$header=$monthName.(($showYear>0) ? " <font color='orange'><b>".$year : "</b></font>");

		$s.="<table class='calendar' border=4 cellspacing=4 cellpadding=4 align=center bordercolor=blue";
		$s.="<tr>";
		$s.="<td align='center' valign='top'>".(($prevMonth=="") ? "&nbsp;" : "<a href='$prevMonth'>&lt;&lt;</a>")."</td>";
		$s.="<td align='center' valign='center' class='calendarHeader' colspan='5'>$header</td>";
		$s.="<td align='center' valign='top'>".(($nextMonth=="") ? "&nbsp;" : "<a href='$nextMonth'>&gt;&gt;</a>")."</td>";
		$s.="</tr>";
		$s.="<tr>";
		$s.="<td align='center' width=70 class='calendarHeader'>".$this->dayNames[($this->startDay)%7]."</td>";
		$s.="<td align='center' width=70 class='calendarHeader'>".$this->dayNames[($this->startDay+1)%7]."</td>";
		$s.="<td align='center' width=70 class='calendarHeader'>".$this->dayNames[($this->startDay+2)%7]."</td>";
		$s.="<td align='center' width=70 class='calendarHeader'>".$this->dayNames[($this->startDay+3)%7]."</td>";
		$s.="<td align='center' width=70 class='calendarHeader'>".$this->dayNames[($this->startDay+4)%7]."</td>";
		$s.="<td align='center' width=70 class='calendarHeader'>".$this->dayNames[($this->startDay+5)%7]."</td>";
		$s.="<td align='center' width=70 class='calendarHeader'>".$this->dayNames[($this->startDay+6)%7]."</td>";
		$s.="</tr>";

		/********************************有些不解*************************************************/
		$d=$this->startDay+1-$first;
		while($d>1)
		{
			$d-=7;
		}
		$today=getdate(time());
		while($d<=$daysInMonth)
		{
			$s.="<tr>";
			for($i=0;$i<7;$i++)
			{
				$class=($year==$today['year'] && $month==$today['mon'] && $d==$today['mday']) ? "calenderToday" : "calendar";
				$s.="<td class='$class' align='center'>";
				if($d>0 && $d<=$daysInMonth)
				{
					$link=$this->getDateLink($d,$month,$year);
					$mtime=mktime();
					$dnow=date("d",$mtime);
					$mnow=date("m",$mtime);
					if($dnow==$d && $mnow==$month)
					{
						$s.=(($link=="") ? $d : "<b><a href='$link'><font face='courier new' color='red'>$d</font></a></b>");

					}
					else
					{
						$s.=(($link=="") ? $d : "<a href='$link'><font face='courier new' color='blue'>$d</font></a>");

					}

				}
				else
				{
					$s.="&nbsp;";
				}
				$s.="</td>";
				$d++;
			}
			$s.="</tr>";
		}
		/***************************************************************************************/
		$s.="</table>";
		return $s;
	}

	//声明一个获取年份的HTML
	function getYearHTML($year)
	{
		$s="";
		$prev=$this->getCalendarLink(0,$year-1);
		$next=$this->getCalendarLink(0,$year+1);
		$s.="<table class='calendar' border='1'>";
		$s.="<tr>";
		$s.="<td align='center' valign='top'>".(($prev=="") ? "&nbsp;" : "<a href='$prev'>&lt;&lt;</a>")."</td>";
		$s.="<td class='calendarHeader' vlign='top' align='center'>".(($this->startMonth>1) ? $year."-".($year+1) : $year)."</td>";
		$s.="<td align='center' valign='top'>".(($next=="") ? "&nbsp;" : "<a href='$next'>&gt;&gt;</a>")."</td>";
		$s.="</tr>";
		$s.="<tr>";
		$s.="<td class='calendar' valign='top'>".$this->getMonthHTML(0+$this->startMonth,$year,0)."</td>";
		$s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(1 + $this->startMonth, $year, 0) ."</td>";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(2 + $this->startMonth, $year, 0) ."</td>";
        $s .= "</tr>";
        $s .= "<tr>";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(3 + $this->startMonth, $year, 0) ."</td>";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(4 + $this->startMonth, $year, 0) ."</td>";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(5 + $this->startMonth, $year, 0) ."</td>";
        $s .= "</tr>";
        $s .= "<tr>";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(6 + $this->startMonth, $year, 0) ."</td>";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(7 + $this->startMonth, $year, 0) ."</td>";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(8 + $this->startMonth, $year, 0) ."</td>";
        $s .= "</tr>";
        $s .= "<tr>";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(9 + $this->startMonth, $year, 0) ."</td>";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(10 + $this->startMonth, $year, 0) ."</td>";
        $s .= "<td class=\"calendar\" valign=\"top\">" . $this->getMonthHTML(11 + $this->startMonth, $year, 0) ."</td>";
        $s .= "</tr>";
        $s .= "</table>";
        return $s;
    }

	//声明一个日期调整函数
	function adjustDate($month,$year)
	{
		$a=array();
		$a[0]=$month;
		$a[1]=$year;
		while($a[0]>12)
		{
			$a[0]-=12;
			$a[1]++;
		}
		while($a[0]<=0)
		{
			$a[0]+=12;
			$a[1]--;
		}
		return $a;
	}

}

class MyCalendar extends Calendar
{
	function getCalendarLink($month,$year)
	{
		$s=getenv('SCRIPT_NAME');	//相当于$_SERVER['SCRIPT_NAME']
		return "$s?month=$month&year=$year";
	}
}




?>
