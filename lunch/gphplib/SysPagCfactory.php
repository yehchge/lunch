<?php

  /****c SysPagCfactory
   *    NAME
   *       SysPagCfactory
   *    FUNCTION
   *       �������O
   *    SEE ALSO
   *       N/A
   *    AUTHOR
   *    MODIFY
   *       12/23/2003   create
   ****
   */
   class SysPagCfactory {

       var $url;
       var $page;
       var $msg_total;
       var $max_rows;
       var $max_pages;
       var $mini_page;

       var $first_page;
       var $end_page;
       var $page_total;
       var $mini_total;

       /****m SysPagCfactory->SysPagCfactory()
        *    NAME
        *       SysPagCfactory
        *    FUNCTION
        *       �غc�l
        *    SEE ALSO
        *       N/A
        *    INPUTS
        *       N/A
        *    OUTPUT
        *       N/A
        ****
        */
        function SysPagCfactory()
        {
           $this->url = "";
           $this->page = "";
           $this->msg_total = "";
           $this->max_rows = "";
           $this->max_pages = "";
         }

        /****m SysPagCfactory->SysPagGetTotalPages
         *    NAME
         *       SysPagGetTotalPages
         *    FUNCTION
         *       ��ܳs�������Ʀr
         *    SEE ALSO
         *       N/A
         *    INPUTS
         *       $max_rows: �C������
         *       $msg_total: �Ҧ�����
         *    OUTPUT
         *       true: �Ҧ����� false: fail
         ****
         */
         function SysPagGetTotalPages( $msg_total, $max_rows=10)
         {
               $page_total = ceil(($msg_total)/$max_rows);
               $this->page_total = $page_total;
               if( !$page_total) { $page_total=1;}
               return $page_total;
          }

         /****m SysPagCfactory->SysPagGetMiniTotal
          *    NAME
          *       SysPagGetMiniTotal
          *    FUNCTION
          *       ���o�@���X�� MAX_ROW ��
          *    SEE ALSO
          *       N/A
          *    INPUTS
          *       $MAX_PAGES: �C MAX_ROW ������
          *    OUTPUT
          *       true: ���� false: fail
          ****
          */
          function SysPagGetMiniTotal( $page_total, $max_pages)
          {
               $mini_total = ceil($page_total/$max_pages);
               $this->mini_total = $mini_total;
               if( !$mini_total) { $mini_total=1;}
               return $mini_total;
           }

          /****m SysPagCfactory->SysPagGetMiniPage
           *    NAME
           *       SysPagGetMiniPage
           *    FUNCTION
           *       ���o�b�ĴX�� MAX_ROW ��
           *    SEE ALSO
           *       N/A
           *    INPUTS
           *       $page: �ĴX��
           *    OUTPUT
           *       true: ���� false: fail
           ****
           */
           function SysPagGetMiniPage( $page)
           {
                 $mini_page = ceil( $page/$this->max_pages);
                 if( $mini_page <= 0 ) {
                    $temp = 1;
                    $this->mini_page = $temp;
                    return $temp;
                 }
                 else if ( $mini_page >= $this->mini_total) {
                    $this->mini_page = $this->mini_total;
                    return $this->mini_total;
                 }
                 else {
                    $this->mini_page = $mini_page;
                    return $mini_page;
                 }
            }

           /****m SysPagCfactory->SysPagGetFirstAndEndPage
            *    NAME
            *       SysPagGetFirstAndEndPage
            *    FUNCTION
            *       ���o�}�l���P������
            *    SEE ALSO
            *       N/A
            *    INPUTS
            *       $MAX_ROWS: �C������
            *       $MAX_PAGES: �C MAX_ROWS ������
            *       $MSG_TOTAL: �Ҧ�����
            *    OUTPUT
            *       true: ���� false: fail
            ****
            */
            function SysPagGetFirstAndEndPage($page_total, $mini_page) {
                 $mini_total = ceil( $page_total/$this->max_pages);
                 // $mini_page = $this->SysPagGetMiniPage( $this->page);
                 $first_page = (( $mini_page -1) * $this->max_pages) + 1;
                 $this->page = $first_page;
                 if( $page_total <= $this->max_pages ) {
                   $end_page = $page_total;
                   $this->end_page = $page_total;
                 }
                 else if ( $mini_page == $mini_total) {
                   $end_page = $page_total;
                   $this->end_page = $page_total;
                 }
                 else {
                   $end_page = $mini_page * $this->max_pages;
                   $this->end_page = $end_page;
                 }
                 if( $first_page <=0) { $first_page = 1;}
                 if( $end_page <=0) { $end_page =1;}
                 return array( $first_page, $end_page);
            }

           /****m SysPagCfactory->SysPagShowPageNumber
            *    NAME
            *       SysPagShowPageNumber
            *    FUNCTION
            *       ��ܳs�������Ʀr
            *    SEE ALSO
            *       N/A
            *    INPUTS
            *       $PAGE: �ثe�Ҧb����
            *    OUTPUT
            *       true: ��ܥi�s���Ʀr false: fail
            ****
            */
            function SysPagShowPageNumber($page, $type="select", $fontstyle="size=\"4\"", $fontstyle1="size=\"2\" color=\"#FF0000\"", $fontstyle2="size=\"2\"") {
               if ( $page <= 0 ) { $page = 1;}
               $url = $this->url;
               $page_total = $this->SysPagGetTotalPages( $this->msg_total, $this->max_rows);
               $mini_total = $this->SysPagGetMiniTotal( $page_total, $this->max_pages);
               $mini_page = $this->SysPagGetMiniPage( $page);
               list( $first_page, $end_page) = $this->SysPagGetFirstAndEndPage( $page_total, $mini_page);

               $body = "";
               if( $type == "number") {
                   $body = "<font $fontstyle2>\n";
                   for( $i = $first_page; $i <= $end_page; $i++) {
                     $prepage = $i;
                     $forward_url = $url. "&page=$prepage";
                     if ( $page == $i ) {
                        $body .= "[<font $fontstyle> $i </font>] ";
                     }
                     else {
                        if($fontstyle) $body .= "<SPAN>";
                        $body .= "[<a href=\"$forward_url\">";
                        $body .= "<font $fontstyle1> $i </font>";
                        $body .= "</a>] ";
                        if($fontstyle) $body .= "</SPAN>";
                     }
                   }
                   $body .= "</font>";
                   return $body;
               }
               else if ( $type == "select") {
                   $body = "<font $fontstyle> �� <select name=\"#\" size=\"1\" onChange=\"JavaScript:location.href=this.options[selectedIndex].value\">";
                   for( $i = $first_page; $i <= $end_page; $i++) {
                     $prepage = $i;
                     $forward_url = $url. "&page=$prepage";
                     if ( $page == $i ) {
                        $body .= "<option value=\"$forward_url\" selected> ";
                        $body .= $i;
                        $body .= " </option>";
                     }
                     else {
                        $body .= "<option value=\"$forward_url\"> ";
                        $body .= $i;
                        $body .= " </option>";
                     }
                  }
                  $body .= "</select>��</font>";
                  return $body;
               }
            }
			
           /****m SysPagCfactory->SysPagShowPageNumberImg
            *    NAME
            *       SysPagShowPageNumberImg
            *    FUNCTION
            *       ��ܳs�������Ʀr
            *    SEE ALSO
            *       N/A
            *    INPUTS
            *       $PAGE: �ثe�Ҧb����
            *    OUTPUT
            *       true: ��ܥi�s���Ʀr false: fail
            ****
            */
            function SysPagShowPageNumberImg( $page, $type="select", $fontstyle="size=\"4\"", $fontstyle1="size=\"2\" color=\"#FF0000\"", $fontstyle2="size=\"2\"")
            {
               if ( $page <= 0 ) { $page = 1;}
               $url = $this->url;
               $page_total = $this->SysPagGetTotalPages( $this->msg_total, $this->max_rows);
               $mini_total = $this->SysPagGetMiniTotal( $page_total, $this->max_pages);
               $mini_page = $this->SysPagGetMiniPage( $page);
               list( $first_page, $end_page) = $this->SysPagGetFirstAndEndPage( $page_total, $mini_page);

               $body = "";
               if( $type == "number") {
                   $body = "<font $fontstyle2>\n";
                   for( $i = $first_page; $i <= $end_page; $i++) {
                     $prepage = $i;
                     $forward_url = $url. "&page=$prepage";
                     if ( $page == $i ) {
                        //$body .= "[<font $fontstyle> $i </font>] ";
						$body .= "<img src='/images/e.gif'>";
                     }
                     else {
                        if($fontstyle) $body .= "<SPAN>";
                        $body .= "<a href=\"$forward_url\">";
                        //$body .= "<font $fontstyle1> $i </font>";
						$body .= "<img src='/images/e.gif'>";
                        $body .= "</a>";
                        if($fontstyle) $body .= "</SPAN>";
                     }
                   }
                   $body .= "</font>";
                   return $body;
               }
               else if ( $type == "select") {
                   $body = "<font $fontstyle> �� <select name=\"#\" size=\"1\" onChange=\"JavaScript:location.href=this.options[selectedIndex].value\">";
                   for( $i = $first_page; $i <= $end_page; $i++) {
                     $prepage = $i;
                     $forward_url = $url. "&page=$prepage";
                     if ( $page == $i ) {
                        $body .= "<option value=\"$forward_url\" selected> ";
                        $body .= $i;
                        $body .= " </option>";
                     }
                     else {
                        $body .= "<option value=\"$forward_url\"> ";
                        $body .= $i;
                        $body .= " </option>";
                     }
                  }
                  $body .= "</select>��</font>";
                  return $body;
               }
            }
			
           /****m SysPagCfactory->SysPagShowPageNumber1
            *    NAME
            *       SysPagShowPageNumber1
            *    FUNCTION
            *       ��ܳs�������Ʀr
            *    SEE ALSO
            *       N/A
            *    INPUTS
            *       $PAGE: �ثe�Ҧb����
            *    OUTPUT
            *       true: ��ܥi�s���Ʀr false: fail
            ****
            */
            function SysPagShowPageNumber1( $page, $type="select", $fontstyle="size=\"2\"", $fontstyle1="size=\"4\"")
            {
               if ( $page <= 0 ) { $page = 1;}
               $url = $this->url;
               $page_total = $this->SysPagGetTotalPages( $this->msg_total, $this->max_rows);
               $mini_total = $this->SysPagGetMiniTotal( $page_total, $this->max_pages);
               $mini_page = $this->SysPagGetMiniPage( $page);
               list( $first_page, $end_page) = $this->SysPagGetFirstAndEndPage( $page_total, $mini_page);

               $body = "";
               if( $type == "number") {
                   $body = "<font $fontstyle>\n";
                   for( $i = $first_page; $i <= $end_page; $i++) {
                     $prepage = $i;
                     $forward_url = $url. "&page=$prepage";
                     if ( $page == $i ) {
                        $body .= "<font $fontstyle1> <b>$i</b></font>/";
                     }
                     else {
                        if($fontstyle) $body .= "<SPAN>";
                        $body .= "<a href=\"$forward_url\">";
                        $body .= "<font $fontstyle> $i</font>";
                        $body .= "</a>";
                        if($fontstyle) $body .= "</SPAN>";
                        $body .= "/";
                     }
                   }
                   return $body;
               }
               else if ( $type == "select") {
                   $body = "<font $fontstyle> �� <select name=\"#\" size=\"1\" onChange=\"JavaScript:location.href=this.options[selectedIndex].value\">";
                   for( $i = $first_page; $i <= $end_page; $i++) {
                     $prepage = $i;
                     $forward_url = $url. "&page=$prepage";
                     if ( $page == $i ) {
                        $body .= "<option value=\"$forward_url\" selected> ";
                        $body .= $i;
                        $body .= " </option>";
                     }
                     else {
                        $body .= "<option value=\"$forward_url\"> ";
                        $body .= $i;
                        $body .= " </option>";
                     }
                  }
                  $body .= "</select>��</font>";
                  return $body;
               }
            }

           /****m SysPagCfactory->SysPagShowMiniLink
            *    NAME
            *       SysPagShowminiLink
            *    FUNCTION
            *       ��ܳs���W(�U) MAX_PAGE ��
            *    SEE ALSO
            *       N/A
            *    INPUTS
            *       $PAGE: �ثe�Ҧb����
            *    OUTPUT
            *       true: ��ܥi�s�� false: fail
            ****
            */
            function SysPagShowMiniLink( $page, $type, $fontstyle="size=\"2\"")
            {
               $next_page = $page + $this->max_pages;
               $last_page = $page - $this->max_pages;
               $page_total = $this->SysPagGetTotalPages( $this->msg_total, $this->max_rows);
               $mini_total = $this->SysPagGetMiniTotal( $page_total, $this->max_pages);
               $mini_page = $this->SysPagGetMiniPage( $page);
               if ( $page <= 0 ) { $page = 1;}
               if ( $mini_page <= 0 ) { $mini_page = 1;}
               $next_page = $mini_page * $this->max_pages + 1;
               $last_page = ($mini_page -2) * $this->max_pages + 1;

               if ( $type == "last" ) {
                 if ( $mini_page <= 1) { $bCondition = 1;} else { $bCondition = 0;}
                 $strID = "�W";
                 $url = $this->url. "&page=$last_page";
               }
               else if ( $type == "next") {
                  if ( $mini_page >= $mini_total) { $bCondition = 1;} else { $bCondition = 0;}
                  $strID = "�U";
                  $url = $this->url. "&page=$next_page";
               }

               $body = "";
               if ( $bCondition) {
                  $body .= "<font $fontstyle>".$strID."<b>".$this->max_pages."</b>��</font>";
               }
               else {
                  if($fontstyle) $body .= "<SPAN>";
                  $body .= "<a href=\"$url\">";
                  $body .= "<font $fontstyle>".$strID."<b>".$this->max_pages."</b>��</font>";
                  $body .= "</a>";
                  if($fontstyle) $body .= "</SPAN>";
               }
               return $body;
             }
			 
			 
           /****m SysPagCfactory->SysPagShowMiniLinkImg
            *    NAME
            *       SysPagShowMiniLinkImg
            *    FUNCTION
            *       ��ܳs���W(�U) MAX_PAGE ��
            *    SEE ALSO
            *       N/A
            *    INPUTS
            *       $PAGE: �ثe�Ҧb����
            *    OUTPUT
            *       true: ��ܥi�s�� false: fail
            ****
            */
            function SysPagShowMiniLinkImg( $page, $type, $fontstyle="size=\"2\"")
            {
               $next_page = $page + $this->max_pages;
               $last_page = $page - $this->max_pages;
               $page_total = $this->SysPagGetTotalPages( $this->msg_total, $this->max_rows);
               $mini_total = $this->SysPagGetMiniTotal( $page_total, $this->max_pages);
               $mini_page = $this->SysPagGetMiniPage( $page);
               if ( $page <= 0 ) { $page = 1;}
               if ( $mini_page <= 0 ) { $mini_page = 1;}
               $next_page = $mini_page * $this->max_pages + 1;
               $last_page = ($mini_page -2) * $this->max_pages + 1;

               if ( $type == "last" ) {
                 if ( $mini_page <= 1) { $bCondition = 1;} else { $bCondition = 0;}
                 $strID = "�W";
                 $url = $this->url. "&page=$last_page";
               }
               else if ( $type == "next") {
                  if ( $mini_page >= $mini_total) { $bCondition = 1;} else { $bCondition = 0;}
                  $strID = "�U";
                  $url = $this->url. "&page=$next_page";
               }

               $body = "";
               if ( $bCondition) {
				  if ($strID=="�W") {
					$body .= "<img src='/images/last10.gif'>";
				  } else if ($strID=="�U")  {
					$body .= "<img src='/images/next10.gif'>";
				  } else {
					$body .= "<font $fontstyle>".$strID."<b>".$this->max_pages."</b>��</font>";
				  }
               }
               else {
                  if($fontstyle) $body .= "<SPAN>";
                  $body .= "<a href=\"$url\">";
                  $body .= "<font $fontstyle>".$strID."<b>".$this->max_pages."</b>��</font>";
                  $body .= "</a>";
                  if($fontstyle) $body .= "</SPAN>";
               }
               return $body;
             }

           /****m SysPagCfactory->SysPagShowMiniLink1
            *    NAME
            *       SysPagShowminiLink1
            *    FUNCTION
            *       ��ܳs���W(�U) MAX_PAGE ��
            *    SEE ALSO
            *       N/A
            *    INPUTS
            *       $PAGE: �ثe�Ҧb����
            *    OUTPUT
            *       true: ��ܥi�s�� false: fail
            ****
            */
            function SysPagShowMiniLink1( $page, $type, $fontstyle="size=\"2\"")
            {
               $next_page = $page + $this->max_pages;
               $last_page = $page - $this->max_pages;
               $page_total = $this->SysPagGetTotalPages( $this->msg_total, $this->max_rows);
               $mini_total = $this->SysPagGetMiniTotal( $page_total, $this->max_pages);
               $mini_page = $this->SysPagGetMiniPage( $page);
               if ( $page <= 0 ) { $page = 1;}
               if ( $mini_page <= 0 ) { $mini_page = 1;}
               $next_page = $mini_page * $this->max_pages + 1;
               $last_page = ($mini_page -2) * $this->max_pages + 1;

               if ( $type == "last" ) {
                 if ( $mini_page <= 1) { $bCondition = 1;} else { $bCondition = 0;}
                 $strID = "Pre";
                 $url = $this->url. "&page=$last_page";
               }
               else if ( $type == "next") {
                  if ( $mini_page >= $mini_total) { $bCondition = 1;} else { $bCondition = 0;}
                  $strID = "More";
                  $url = $this->url. "&page=$next_page";
               }

               $body = "";
               if ( $bCondition) {
                  $body .= "<font $fontstyle>".$strID."</font>";
               }
               else {
                  if($fontstyle) $body .= "<SPAN>";
                  $body .= "<a href=\"$url\">";
                  $body .= "<font $fontstyle>".$strID."</font>";
                  $body .= "</a>";
                  if($fontstyle) $body .= "</SPAN>";
               }
               return $body;
             }

           /****m SysPagCfactory->SysPagShowPageLink
            *    NAME
            *       SysPagShowPageLink
            *    FUNCTION
            *       ��ܳs���W(�U)�@��
            *    SEE ALSO
            *       N/A
            *    INPUTS
            *       $page: �ثe�Ҧb����
            *       $type: next->�U�@�� ; last: �W�@��
            *    OUTPUT
            *       true: ��ܥi�s�� false: fail
            ****
            */
            function SysPagShowPageLink( $page, $type="next", $fontstyle="size=\"2\"")
            {
              $page_total = $this->SysPagGetTotalPages( $this->msg_total, $this->max_rows);
              if( $page <= 0 ) { $page = 1; }
              if( $page_total <= 0 ) { $page_total = 1; }
              if( $page >= $page_total) { $next_page = $page_total; } else { $next_page=$page+1; }
              if( ($page -1) <= 0 ) { $last_page = 1; } else { $last_page=($page-1); }
              $url = $this->url;
              $body = "";

              if( $type == "last") {
                $url .= "&page=$last_page";
                if( $page >=2 ){
                  if($fontstyle) $body .= "<SPAN>";
                  $body .= "<a href=\"$url\">";
                  $body .= "<font $fontstyle> �W�@�� </font>";
                  $body .= "</a>";
                  if($fontstyle) $body .= "</SPAN>";
                } else {
                  $body .= "<font $fontstyle> �W�@�� </font>";
                }
              } else if ( $type == "next" ) {
                $url .= "&page=$next_page";
                if( $page_total > $page){
                  if($fontstyle) $body .= "<SPAN>";
                  $body .= "<a href=\"$url\">";
                  $body .= "<font $fontstyle> �U�@�� </font>";
                  $body .= "</a>";
                  if($fontstyle) $body .= "</SPAN>";
                } else {
                  $body .= "<font $fontstyle> �U�@�� </font>";
                }
              }
              return $body;
            }
			

           /****m SysPagCfactory->SysPagShowPageLinkByItem
            *    NAME
            *       SysPagShowPageLinkByItem
            *    FUNCTION
            *       ��ܳs���W(�U)�@��
            *    SEE ALSO
            *       N/A
            *    INPUTS
            *       $page: �ثe�Ҧb����
            *       $type: next->�U�@�� ; last: �W�@��
            *    OUTPUT
            *       true: ��ܥi�s�� false: fail
            ****
            */
            function SysPagShowPageLinkByItem( $page, $type="next", $fontstyle="size=\"2\"")
            {
              $page_total = $this->SysPagGetTotalPages( $this->msg_total, $this->max_rows);
              if( $page <= 0 ) { $page = 1; }
              if( $page_total <= 0 ) { $page_total = 1; }
              if( $page >= $page_total) { $next_page = $page_total; } else { $next_page=$page+1; }
              if( ($page -1) <= 0 ) { $last_page = 1; } else { $last_page=($page-1); }
              $url = $this->url;
              $body = "";

              if( $type == "last") {
                $url .= "&page=$last_page";
                if( $page >=2 ){
                  if($fontstyle) $body .= "<SPAN>";
                  $body .= "<a href=\"$url\">";
                  $body .= "<font $fontstyle> �W�@�� </font>";
                  $body .= "</a>";
                  if($fontstyle) $body .= "</SPAN>";
                } else {
                  $body .= "<font $fontstyle> �W�@�� </font>";
                }
              } else if ( $type == "next" ) {
                $url .= "&page=$next_page";
                if( $page_total > $page){
                  if($fontstyle) $body .= "<SPAN>";
                  $body .= "<a href=\"$url\">";
                  $body .= "<font $fontstyle> �U�@�� </font>";
                  $body .= "</a>";
                  if($fontstyle) $body .= "</SPAN>";
                } else {
                  $body .= "<font $fontstyle> �U�@�� </font>";
                }
              }
              return $body;
            }

			
           /****m SysPagCfactory->SysPagShowPageLinkImg
            *    NAME
            *       SysPagShowPageLinkImg
            *    FUNCTION
            *       ��ܳs���W(�U)�@��
            *    SEE ALSO
            *       N/A
            *    INPUTS
            *       $page: �ثe�Ҧb����
            *       $type: next->�U�@�� ; last: �W�@��
            *    OUTPUT
            *       true: ��ܥi�s�� false: fail
            ****
            */
            function SysPagShowPageLinkImg( $page, $type="next", $fontstyle="size=\"2\"")
            {
              $page_total = $this->SysPagGetTotalPages( $this->msg_total, $this->max_rows);
              if( $page <= 0 ) { $page = 1; }
              if( $page_total <= 0 ) { $page_total = 1; }
              if( $page >= $page_total) { $next_page = $page_total; } else { $next_page=$page+1; }
              if( ($page -1) <= 0 ) { $last_page = 1; } else { $last_page=($page-1); }
              $url = $this->url;
              $body = "";

              if( $type == "last") {
                $url .= "&page=$last_page";
                if( $page >=2 ){
                  if($fontstyle) $body .= "<SPAN>";
                  $body .= "<a href=\"$url\">";
                  //$body .= "<font $fontstyle> �W�@�� </font>";
				  $body .= "<img src='/images/last.gif'>";
                  $body .= "</a>";
                  if($fontstyle) $body .= "</SPAN>";
                } else {
                  //$body .= "<font $fontstyle> �W�@�� </font>";
				  $body .= "<img src='/images/last.gif'>";
                }
              } else if ( $type == "next" ) {
                $url .= "&page=$next_page";
                if( $page_total > $page){
                  if($fontstyle) $body .= "<SPAN>";
                  $body .= "<a href=\"$url\">";
                  //$body .= "<font $fontstyle> �U�@�� </font>";
				  $body .= "<img src='/images/next.gif'>";
                  $body .= "</a>";
                  if($fontstyle) $body .= "</SPAN>";
                } else {
                  //$body .= "<font $fontstyle> �U�@�� </font>";
				  $body .= "<img src='/images/next.gif'>";
                }
              }
              return $body;
            }
			
   } //end of the SysPagCfactory
?>