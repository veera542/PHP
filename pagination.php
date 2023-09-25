public function get_pagination($currentPage = null, $total_no_of_pages = null){
    $pagination_buttons = '';
    $pagination_buttons .= '<div class="pagination_rounded"> <ul>';
    
    if (!empty($currentPage)) {
        $currentPage = $currentPage;
    } else {
        $currentPage = 1;
    }
    
    if ($total_no_of_pages > 1) {
        if ($currentPage > 1) {
            $pagination_buttons .= '<li> <a href="javascript:void(0);" class="prev pagelinks" data-no="'.(($currentPage - 1)).'"> <i class="fa fa-angle-left" aria-hidden="true"></i> Prev </a> </li>';
        }
        
        for ($counter = $currentPage; $counter <= $currentPage + 4; $counter++) {  
            if ($counter <= $total_no_of_pages) {   
                $class = ($counter == $currentPage) ? 'button-atv' : '';       
                $pagination_buttons .= '<li><a href="javascript:void(0);" class="pagelinks '.$class.'" data-no="'.($counter).'">' . $counter . '</a> </li>';
                if ($counter == $total_no_of_pages) {
                    break;
                }
            }             
        }

        if ($currentPage < $total_no_of_pages) {
            $pagination_buttons .= '<li><a href="javascript:void(0);" class="next pagelinks" data-no="'.($currentPage + 1).'"> Next <i class="fa fa-angle-right" aria-hidden="true"></i></a> </li>';
            $pagination_buttons .= '<li><a href="javascript:void(0);" class="next pagelinks" data-no="'.($total_no_of_pages).'"> Last <i class="fa fa-angle-right" aria-hidden="true"></i></a> </li>';
        }      
        
        $pagination_buttons .= '</ul>';
    }  
    
    $pagination_buttons .= '</div>';
    
    return  $pagination_buttons;
}
