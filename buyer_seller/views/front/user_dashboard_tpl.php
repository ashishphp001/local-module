<link rel="stylesheet" href="<?php echo FRONT_MEDIA_URL; ?>css/das/uikit.almost-flat.min.css" media="all">
<link rel="stylesheet" href="<?php echo FRONT_MEDIA_URL; ?>css/das/main.min.css" media="all">
<!-- main header end -->

<?php
echo $this->load->view($UserSideBar);
?>

<div class="row">
    <div id="page_content">
        <div id="page_content_inner">
            <div class="col s12 m12 part-padding">
                <div class="company-rofile-source col s12 m8 l8">
                    <div class="card card-stats">
                        <?php
                        $imagename = $getUserData['varImage'];
                        $imagepath = 'upimages/users/images/' . $imagename;

                        if (file_exists($imagepath) && $getUserData['varImage'] != '') {
                            $image_thumb = image_thumb($imagepath, 200, 200);
                        } else {
                            $image_thumb = FRONT_MEDIA_URL . "images/no_img/ib_no_image.jpg";
                        }
                        ?>
                        <div class="user_heading user_heading_bg" style="background-image: url('<?php echo FRONT_MEDIA_URL; ?>images/das-bg.jpg')">
                            <div class="bg_overlay">
                                <div class="user_heading_avatar">
                                    <div class="thumbnail">
                                        <img src="<?php echo $image_thumb; ?>" alt="<?php echo $getUserData['varCompany']; ?>" title="<?php echo $getUserData['varCompany']; ?>">
                                    </div>
                                </div>
                                <div class="user_heading_content">
                                    <h2 class="heading_b uk-margin-bottom"><span class="uk-text-truncate"><?php echo $getUserData['varCompany']; ?></span><span class="sub-heading"><i class="fas fa-map-marker-alt"></i>&nbsp;<?php echo $getUserData['varCity']; ?> (<?php echo $getUserData['varCountry']; ?>)</span></h2>
                                    <ul class="user_stats">
                                        <li>
                                            <h4 class="heading_a">ID : <span class=""><?php echo $getUserData['int_id']; ?></span></h4>
                                        </li>
                                    </ul>
                                </div>
                                <div class="right-profile">
                                    <h5>Profile Assistance</h5>
                                    <div class="assistenta">
                                        <p><i class="fas fa-user-tie"></i><?php echo SITE_NAME; ?></p>
                                        <p><a href="<?php echo "mailto:" . EMAIL_ADD; ?>"><i class="far fa-envelope-open"></i><?php echo EMAIL_ADD; ?></a></p>
                                        <p><i class="material-icons">call</i> <?php
                                        if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android')) {
                                            ?><a href="tel:<?php echo CONTACT_PHONE; ?>"><?php echo CONTACT_PHONE; ?></a>
                                        <?php } else { ?>
                                            <?php
                                            echo CONTACT_PHONE;
                                        }
                                        ?></p>
                                    </div>
                                    <div class="float-changer">
                                        <a href=""><i class="far fa-comments"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info-continue">
                            
                            <?php 
                            $getbusinesstype=$this->Module_Model->getBusinessTypeList($getUserData['varBusinessType']);
                            ?>
                            <div class="display-info-set">
                                <h5>
                                    <i class="far fa-envelope-open"></i>Business type</h5>
                                <div class="set-all-info">
                                    <span><?php echo $getbusinesstype; ?></span>
                                </div>
                            </div>
                            <div class="display-info-set">
                                <h5>
                                    <i class="far fa-envelope-open"></i>Membership</h5>
                                <div class="set-all-info">
                                    <span>Plan, Ordinary</span>
                                </div>
                            </div>
                            <div class="button-slim">
                                <a href="">My catalogue</a>
                            </div>
                            
                            <div class="button-slim">
                                <a href="">Upgrade membership</a>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="das-source col s12 m4 l4" id="dashboard_sortable_cards">
                    <div class="col s12 m12 l12">
                        <div class="open-source card progress-dass">
                            <div class="make-icon">                        
                                <div class="card-header">
                                    <i class="far fa-user-circle"></i>
                                </div>
                                <h4>Profile</h4>
                            </div>
                            <ul>
                                <li><a href="">Personal Details <b>50%</b></a>
                                    <div class="progress">
                                        <div class="determinate" style="width: 50%"></div>
                                    </div>                  
                                </li>
                                <li><a href="">Company Info <b>25%</b></a>
                                    <div class="progress">
                                        <div class="determinate" style="width: 25%"></div>
                                    </div>                  
                                </li>
                                <li><a href="">Products <b>30%</b></a>
                                    <div class="progress">
                                        <div class="determinate" style="width: 30%"></div>
                                    </div>                  
                                </li>
                                <li><a href="">Buy Requirments <b>10%</b></a>
                                    <div class="progress">
                                        <div class="determinate" style="width: 10%"></div>
                                    </div>                  
                                </li>

                            </ul>
                        </div>
                    </div>                         

                </div>
            </div>
            <div class="col s12 m12">

                <div class="col s12 m4 l4">
                    <div class="open-source card">
                        <div class="make-icon">                        
                            <div class="card-header">
                                <i class="far fa-heart"></i>
                            </div>
                            <h4>My Favourite</h4>
                        </div>
                        <ul>
                            <li><a href="">
                                    Products       
                                    <span class="pull-right">50</span>  </a>                 
                            </li>
                            <li><a href="">Buylead
                                    <span class="pull-right">50</span>  </a>                                                     
                            </li>

                        </ul>
                    </div>
                    <div class="col s12 m12 l12 padding">
                        <div class="open-source card">
                            <div class="make-icon">                        
                                <div class="card-header">
                                    <i class="far fa-star"></i>
                                </div>
                                <h4>User Rate</h4>
                            </div>
                            <ul>
                                <li><a href="">
                                        Response rate    
                                        <span class="pull-right">50%</span>  </a>                 
                                </li>
                                <li><a href=""> Response rate    
                                        <span class="pull-right">5 hour</span> </a>                                                     
                                </li>

                            </ul>
                        </div>



                    </div>
                </div>


                <div class="col s12 m4 l4">
                    <div class="open-source card">
                        <div class="make-icon">                        
                            <div class="card-header">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h4>My sell Lead</h4>
                        </div>
                        <ul>
                            <li><a href="">
                                    Total       
                                    <span class="pull-right">50</span>     </a>              
                            </li>
                            <li>
                                <a href="">Approve
                                    <span class="pull-right">50</span>  </a>                                                     
                            </li>
                            <li>
                                <a href="">Waiting
                                    <span class="pull-right"> 50</span></a>
                            </li>

                            <li><a href="">Rejected
                                    <span class="pull-right">50</span></a>
                            </li>

                        </ul>
                    </div>
                </div> 
                <div class="col s12 m4 l4">


                    <div class="open-source card">
                        <div class="make-icon">                        
                            <div class="card-header">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <h4>Quotation</h4>
                        </div>
                        <ul>
                            <li><a href="">
                                    Total       
                                    <span class="pull-right">5</span>  </a>                 
                            </li>
                            <li><a href="">
                                    Send       
                                    <span class="pull-right">5</span>     </a>              
                            </li>
                            <li><a href="">Receive
                                    <span class="pull-right">50</span>    </a>                                                   
                            </li>

                        </ul>
                    </div>
                </div> 




                <!--  <div class="col s12 m4 l4">
                      <div class="open-source card user-info-source">
                         <div class="make-icon">                        
                             <div class="card-header">
                                <i class="far fa-user-circle"></i>
                             </div>
                             <h4>Profile Assistance</h4>
                         </div>
                         <ul>
                             <li>
                                 <i class="fas fa-user-tie"></i>Badal Patel               
                             </li>
                             <li><a href=""><i class="far fa-envelope-open"></i>demo@gmail.com</a>                                                     
                             </li>
                             <li>
                                 <i class="material-icons">call</i>+91 9999999999
                             </li>

                         </ul>
                     </div>
                    
                      
                 </div> --> 
                <div class="col s12 m4 l4">
                    <div class="open-source card">
                        <div class="make-icon">                        
                            <div class="card-header">
                                <i class="fab fa-product-hunt"></i>
                            </div>
                            <h4>My products</h4>
                        </div>
                        <ul>
                            <li><a href="">
                                    Total       
                                    <span class="pull-right">50</span>
                                </a>                   
                            </li>
                            <li><a href="">
                                    Approved
                                    <span class="pull-right">50</span>  </a>                                                     
                            </li>
                            <li>
                                <a href="">Waiting
                                    <span class="pull-right"> 50</span></a>
                            </li>

                            <li>
                                <a href="">Rejected
                                    <span class="pull-right">50</span></a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="col s12 m4 l4">
                    <div class="open-source card">
                        <div class="make-icon">                        
                            <div class="card-header">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h4>My Inquiry</h4>
                        </div>
                        <ul class="only-one">
                            <h4  class="inq-dev">Incoming</h4>
                            <li><a href="">
                                    Responsed       
                                    <span class="pull-right">50</span>  </a>                 
                            </li>
                            <li>
                                <a href="">Not responsed
                                    <span class="pull-right">50</span></a>                                                       
                            </li>
                            <li>
                                <a href="">Read
                                    <span class="pull-right"> 50</span></a>
                            </li>

                            <li>
                                <a href="">Un read
                                    <span class="pull-right">50</span></a>
                            </li>

                        </ul>
                        <ul class="only-one outgoing">
                            <h4  class="inq-dev">Outgoing</h4>
                            <li><a href="">
                                    Responsed       
                                    <span class="pull-right">50</span>  </a>                 
                            </li>
                            <li>
                                <a href="">Not responsed
                                    <span class="pull-right">50</span></a>                                                       
                            </li>
                            <li>
                                <a href="">Read
                                    <span class="pull-right"> 50</span></a>
                            </li>

                            <li>
                                <a href="">Un read
                                    <span class="pull-right">50</span></a>
                            </li>

                        </ul>
                    </div>
                </div>


            </div>

        </div>


        <div class="col s12 m12 dasbord-style">
            <div class="col s12 m12 padding">
                <div class="col s12 m12 padding product-supplier-detail rfq-formal">

                    <div class="supplier-product">
                        <h4>Recommended RFQ</h4>
                        <div class="slider-effect">

                            <section class="das-slide slider1">

                                <div class="slide inline">

                                    <div class="card display-bl">
                                        <div class="card-smell">

                                            <div class="box-image-s">

                                                <img src="<?php echo FRONT_MEDIA_URL; ?>images/choose-pro.jpg" alt="John">

                                            </div>

                                            <div class="id-boxes-detail">

                                                <div class="caption-smell"><p class="shortlist-id"><i class="fas fa-map-marker-alt"></i>&nbsp;Rajkot (India)</p> </div> 

                                                <div class="name-define">

                                                    <a href="" class="name-pro-surp">Multy Cart</a>
                                                    <h1>Badal Patel</h1>


                                                </div>
                                                <div class="small-qunt-pri">
                                                    <ul>
                                                        <li>Qty
                                                            <span>5 peace</span>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <span class="all-btn card">

                                                    <a href="#"><i class="fas fa-user-edit "></i>Access By Lead</a>

                                                </span>


                                            </div>                                       

                                        </div>

                                    </div>

                                </div>
                                <div class="slide inline">

                                    <div class="card display-bl">
                                        <div class="card-smell">

                                            <div class="box-image-s">

                                                <img src="<?php echo FRONT_MEDIA_URL; ?>images/choose-pro.jpg" alt="John">

                                            </div>

                                            <div class="id-boxes-detail">

                                                <div class="caption-smell"><p class="shortlist-id"><i class="fas fa-map-marker-alt"></i>&nbsp;Rajkot (India)</p> </div> 

                                                <div class="name-define">

                                                    <a href="" class="name-pro-surp">Multy Cart</a>
                                                    <h1>Badal Patel</h1>


                                                </div>
                                                <div class="small-qunt-pri">
                                                    <ul>
                                                        <li>Qty
                                                            <span>5 peace</span>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <span class="all-btn card">

                                                    <a href="#"><i class="fas fa-user-edit "></i>Access By Lead</a>

                                                </span>


                                            </div>                                       

                                        </div>

                                    </div>

                                </div>
                                <div class="slide inline">

                                    <div class="card display-bl">
                                        <div class="card-smell">

                                            <div class="box-image-s">

                                                <img src="<?php echo FRONT_MEDIA_URL; ?>images/choose-pro.jpg" alt="John">

                                            </div>

                                            <div class="id-boxes-detail">

                                                <div class="caption-smell"><p class="shortlist-id"><i class="fas fa-map-marker-alt"></i>&nbsp;Rajkot (India)</p> </div> 

                                                <div class="name-define">

                                                    <a href="" class="name-pro-surp">Multy Cart</a>
                                                    <h1>Badal Patel</h1>


                                                </div>
                                                <div class="small-qunt-pri">
                                                    <ul>
                                                        <li>Qty
                                                            <span>5 peace</span>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <span class="all-btn card">

                                                    <a href="#"><i class="fas fa-user-edit "></i>Access By Lead</a>

                                                </span>


                                            </div>                                       

                                        </div>

                                    </div>

                                </div>
                                <div class="slide inline">

                                    <div class="card display-bl">
                                        <div class="card-smell">

                                            <div class="box-image-s">

                                                <img src="<?php echo FRONT_MEDIA_URL; ?>images/choose-pro.jpg" alt="John">

                                            </div>

                                            <div class="id-boxes-detail">

                                                <div class="caption-smell"><p class="shortlist-id"><i class="fas fa-map-marker-alt"></i>&nbsp;Rajkot (India)</p> </div> 

                                                <div class="name-define">

                                                    <a href="" class="name-pro-surp">Multy Cart</a>
                                                    <h1>Badal Patel</h1>


                                                </div>
                                                <div class="small-qunt-pri">
                                                    <ul>
                                                        <li>Qty
                                                            <span>5 peace</span>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <span class="all-btn card">

                                                    <a href="#"><i class="fas fa-user-edit "></i>Access By Lead</a>

                                                </span>


                                            </div>                                       

                                        </div>

                                    </div>

                                </div>
                                <div class="slide inline">

                                    <div class="card display-bl">
                                        <div class="card-smell">

                                            <div class="box-image-s">

                                                <img src="<?php echo FRONT_MEDIA_URL; ?>images/choose-pro.jpg" alt="John">

                                            </div>

                                            <div class="id-boxes-detail">

                                                <div class="caption-smell"><p class="shortlist-id"><i class="fas fa-map-marker-alt"></i>&nbsp;Rajkot (India)</p> </div> 

                                                <div class="name-define">

                                                    <a href="" class="name-pro-surp">Multy Cart</a>
                                                    <h1>Badal Patel</h1>


                                                </div>
                                                <div class="small-qunt-pri">
                                                    <ul>
                                                        <li>Qty
                                                            <span>5 peace</span>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <span class="all-btn card">

                                                    <a href="#"><i class="fas fa-user-edit "></i>Access By Lead</a>

                                                </span>


                                            </div>                                       

                                        </div>

                                    </div>

                                </div>

                            </section>

                        </div>

                    </div>
                </div>
            </div>

            <div class="col s12 m12 rfq-formal">
                <div class="col s12 m12 padding product-supplier-detail">

                    <div class="supplier-product">
                        <h4>Recommended Products</h4>
                        <div class="slider-effect">

                            <section class="das-slide1 slider1">

                                <div class="slide card inline" data-wow-duration="2s" data-wow-delay="500ms">

                                    <div class="cate-img card">

                                        <img src="<?php echo FRONT_MEDIA_URL; ?>images/cat-box.png" alt="category">

                                    </div>

                                    <div class="cat-detail">

                                        <p class="edge-head">Edge International</p>

                                        <h1><a href="#">Balaji chemical</a></h1>

                                        <h6>Amritsar(India)</h6>
                                        <div class="price-special">
                                            <h6>Price</h6>
                                            <span>$800 / Bag</span>
                                        </div>
                                        <div class="price-special">
                                            <h6>MOQ</h6>
                                            <span> 2500 Bag</span>
                                        </div>
                                    </div>

                                    <div class="cat-button">

                                        <a href="#" class="waves-effect waves-light btn"><img src="<?php echo FRONT_MEDIA_URL; ?>images/call.png" alt="call"> Contact</a>

                                        <a href="#" class="waves-effect waves-light btn"><i class="far fa-heart"></i>Favourite</a>

                                    </div>

                                </div>
                                <div class="slide card inline">

                                    <div class="cate-img card">

                                        <img src="<?php echo FRONT_MEDIA_URL; ?>images/cat-box.png" alt="category">

                                    </div>

                                    <div class="cat-detail">

                                        <p class="edge-head">Edge International</p>

                                        <h1><a href="#">Balaji chemical</a></h1>

                                        <h6>Amritsar(India)</h6>
                                        <div class="price-special">
                                            <h6>Price</h6>
                                            <span>$800 / Bag</span>
                                        </div>
                                        <div class="price-special">
                                            <h6>MOQ</h6>
                                            <span> 2500 Bag</span>
                                        </div>
                                    </div>

                                    <div class="cat-button">

                                        <a href="#" class="waves-effect waves-light btn"><img src="<?php echo FRONT_MEDIA_URL; ?>images/call.png" alt="call"> Contact</a>

                                        <a href="#" class="waves-effect waves-light btn"><i class="far fa-heart"></i>Favourite</a>

                                    </div>

                                </div>
                                <div class="slide card inline">

                                    <div class="cate-img card">

                                        <img src="<?php echo FRONT_MEDIA_URL; ?>images/cat-box.png" alt="category">

                                    </div>

                                    <div class="cat-detail">

                                        <p class="edge-head">Edge International</p>

                                        <h1><a href="#">Balaji chemical</a></h1>

                                        <h6>Amritsar(India)</h6>
                                        <div class="price-special">
                                            <h6>Price</h6>
                                            <span>$800 / Bag</span>
                                        </div>
                                        <div class="price-special">
                                            <h6>MOQ</h6>
                                            <span> 2500 Bag</span>
                                        </div>
                                    </div>

                                    <div class="cat-button">

                                        <a href="#" class="waves-effect waves-light btn"><img src="<?php echo FRONT_MEDIA_URL; ?>images/call.png" alt="call"> Contact</a>

                                        <a href="#" class="waves-effect waves-light btn"><i class="far fa-heart"></i>Favourite</a>

                                    </div>

                                </div>

                                <div class="slide card inline">

                                    <div class="cate-img card">

                                        <img src="<?php echo FRONT_MEDIA_URL; ?>images/cat-box.png" alt="category">

                                    </div>

                                    <div class="cat-detail">

                                        <p class="edge-head">Edge International</p>

                                        <h1><a href="#">Balaji chemical</a></h1>

                                        <h6>Amritsar(India)</h6>
                                        <div class="price-special">
                                            <h6>Price</h6>
                                            <span>$800 / Bag</span>
                                        </div>
                                        <div class="price-special">
                                            <h6>MOQ</h6>
                                            <span> 2500 Bag</span>
                                        </div>
                                    </div>

                                    <div class="cat-button">

                                        <a href="#" class="waves-effect waves-light btn"><img src="<?php echo FRONT_MEDIA_URL; ?>images/call.png" alt="call"> Contact</a>

                                        <a href="#" class="waves-effect waves-light btn"><i class="far fa-heart"></i>Favourite</a>

                                    </div>

                                </div>
                                <div class="slide card inline">

                                    <div class="cate-img card">

                                        <img src="<?php echo FRONT_MEDIA_URL; ?>images/cat-box.png" alt="category">

                                    </div>

                                    <div class="cat-detail">

                                        <p class="edge-head">Edge International</p>

                                        <h1><a href="#">Balaji chemical</a></h1>

                                        <h6>Amritsar(India)</h6>
                                        <div class="price-special">
                                            <h6>Price</h6>
                                            <span>$800 / Bag</span>
                                        </div>
                                        <div class="price-special">
                                            <h6>MOQ</h6>
                                            <span> 2500 Bag</span>
                                        </div>
                                    </div>

                                    <div class="cat-button">

                                        <a href="#" class="waves-effect waves-light btn"><img src="<?php echo FRONT_MEDIA_URL; ?>images/call.png" alt="call"> Contact</a>

                                        <a href="#" class="waves-effect waves-light btn"><i class="far fa-heart"></i>Favourite</a>

                                    </div>

                                </div>


                            </section>

                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
