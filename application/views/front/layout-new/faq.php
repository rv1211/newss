<section class="breadcrumb_area">
    <img class="breadcrumb_shap" src="<?= base_url(); ?>assets/front-end/img/breadcrumb/banner_bg.png" alt="">
    <div class="container">
        <div class="breadcrumb_content text-center">
            <h1 class="f_p f_700 f_size_50 l_height50 mb_20">FAQ</h1>
            <p class="f_400 f_size_16 l_height26">Browse through the most frequently asked questions</p>
        </div>
    </div>
</section>
<section class="faq_area bg_color sec_pad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content faq_content" id="myTabContent">
                    <div class="tab-pane fade show active" id="purchas" role="tabpanel" aria-labelledby="purchas-tab">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                            aria-expanded="true" aria-controls="collapseOne">
                                            1. Is pack and drop Logistics a courier company?<i class="ti-plus"></i><i
                                                class="ti-minus"></i>
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        Pack and Drop Logistics is a courier aggregator. We are tied up with multiple
                                        courier companies like, Delhivery, xpressbees, Shadowfax, ekart, ecom express,
                                        FedEx etc., so that you can avail the service of any courier company you want,
                                        under a single platform.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse"
                                            data-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            2. What will happen if my parcel gets lost?<i class="ti-plus"></i><i
                                                class="ti-minus"></i>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        In case any parcel is lost or damaged due to the mishandling of the courier
                                        company, you will receive compensation against the same. We have different
                                        liability clauses for different partners which include a certain amount (ex: INR
                                        X) or Product value whichever is lower. (The value of X depends on individual
                                        logistics partners). The amount will be mentioned in your agreement when you
                                        sign up with us.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse"
                                            data-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            3. How does the volumetric calculation work?<i class="ti-plus"></i><i
                                                class="ti-minus"></i>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        The volumetric weight is calculated using the below-mentioned formula. <br>
                                        Please refer to the image below. <br>
                                        <img src="<?=base_url();?>assets/front-end/img/custom/faq_volumetric_weight.jpg"
                                            alt=""> <br>
                                        Please take cf (conversion factor) = 4500 in case of FedEx
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingfour">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse"
                                            data-target="#collapsefour" aria-expanded="false"
                                            aria-controls="collapsefour">
                                            4. How pickup will work?<i class="ti-plus"></i><i class="ti-minus"></i>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapsefour" class="collapse" aria-labelledby="headingfour"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        Once the shipping label is generated, pick up will automatically be assigned to
                                        the respective courier company. The delivery boys from that particular courier
                                        company will come to pick up your order. <br>
                                        However, the first-time pickup might take up to 24-48 hours. Once the processing
                                        is completed, your pickup will be regularized.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingfive">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse"
                                            data-target="#collapsefive" aria-expanded="false"
                                            aria-controls="collapsefive">
                                            5. Are there any additional charges apart from shipping costs? (Any Setup
                                            fees or monthly charges)<i class="ti-plus"></i><i class="ti-minus"></i>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapsefive" class="collapse" aria-labelledby="headingfive"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        There are absolutely no setup fees or monthly charges applicable when you shop
                                        with us. You can sign up with us for FREE. Our easy wallet system provides an
                                        easy recharge option whenever you want to ship any parcel through us.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingsix">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse"
                                            data-target="#collapsesix" aria-expanded="false"
                                            aria-controls="collapsesix">
                                            6. When will my parcel be delivered?<i class="ti-plus"></i><i
                                                class="ti-minus"></i>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapsesix" class="collapse" aria-labelledby="headingsix"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        The approximate delivery time depends upon the different zones you are shipping
                                        to. Refer to the chart given below <br><br>
                                        <table width="100%" colspacing="5" colspading="7">
                                            <tr>
                                                <th>Zone</th>
                                                <th>Area</th>
                                                <th>Delivery time</th>
                                            </tr>
                                            <tr>
                                                <td>Zone A</td>
                                                <td>Pickup and delivery within the same city</td>
                                                <td>1 to 2 days</td>
                                            </tr>
                                            <tr>
                                                <td>Zone B</td>
                                                <td>Pickup and delivery within the same state or neighboring state</td>
                                                <td>2 to 3 days</td>
                                            </tr>
                                            <tr>
                                                <td>Zone C</td>
                                                <td>Pickup and delivery within two different metro cities</td>
                                                <td>2 to 4 days</td>
                                            </tr>
                                            <tr>
                                                <td>Zone D</td>
                                                <td>Pickup and Delivery in rest of India (non-metro cities)</td>
                                                <td>4 to 5 days</td>
                                            </tr>
                                            <tr>
                                                <td>Zone E</td>
                                                <td>Pickup and Delivery in Jammu & Kashmir and North-Eastern India</td>
                                                <td>4 to 6 days</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingseven">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse"
                                            data-target="#collapseseven" aria-expanded="false"
                                            aria-controls="collapseseven">
                                            7. What happens if we receive a damaged product or wrong in return?<i
                                                class="ti-plus"></i><i class="ti-minus"></i>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseseven" class="collapse" aria-labelledby="headingseven"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        Whenever you are receiving a return order, please check it properly before
                                        accepting it from the delivery boy. In case you receive any damaged product,
                                        mention it to the present person. Following that, you need to write us an email
                                        regarding your issue, or you can raise a support ticket from your end. We will
                                        look into the matter and solve it at the earliest.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingeight">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse"
                                            data-target="#collapseeight" aria-expanded="false"
                                            aria-controls="collapseeight">
                                            8. How does the remittance cycle work?<i class="ti-plus"></i><i
                                                class="ti-minus"></i>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseeight" class="collapse" aria-labelledby="headingeight"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        Our delivery remittance features clear your money after 7 day of delivery.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingnine">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse"
                                            data-target="#collapsenine" aria-expanded="false"
                                            aria-controls="collapsenine">
                                            9. Whom should I contact Pack and Drop Logistics or a courier partner?<i
                                                class="ti-plus"></i><i class="ti-minus"></i>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapsenine" class="collapse" aria-labelledby="headingnine"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        Whenever you sign up with us, you will be assigned a personal accounts manager
                                        or SPOC, who will be a single point of contact for all your queries. You can
                                        reach out to him at any time during business hours via email or call. Other than
                                        this, you can also raise a support ticket from your end.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>