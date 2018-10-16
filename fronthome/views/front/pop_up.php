<script type="text/javascript">
function validate() {
        var name=trim(document.getElementById("name").value);
        if(name==""){
            alert("Please enter your name.");
            document.getElementById('name').focus();
            return false;
        }
        var popup = document.getElementById('Accept').checked;
        
        if(popup == true) {
            
            Setpopupsession(popup)

            disablePopup();
        } else {

            document.getElementById('PopupContent').style.display = "none";
            document.getElementById('PopupContent1').style.display = "";
            return false;
        }
    }
     function Setpopupsession(pop)
    {
        var varpop = pop;
        var exist;
        $.ajax({
            type: "POST",
            url: "<?php echo SITE_PATH; ?>fronthome/Set_Session",
            data: "ajax=Y&acceptsession="+varpop+"",
            async: false,
            success: function(result)
            {
                if(result==1){
                    exist =  false;
                }else{
                    exist =  true;
                }
            }
        }); 
        return exist;
    }
            
     $(document).keydown(function(e) {
        // ESCAPE key pressed
        if (e.keyCode == 27) {
            disablePopup();
        }
    });
    $(document).keydown(function(e) {
        // ESCAPE key pressed
        if (e.keyCode == 10) {
            //            alert('sdgdfgdfg');
            return false;
        }
    });
        </script>

<div class="container Inner-container">
    <div class="cross_icn" onclick="return disablePopup();" title="Cancel"></div>
    <div id="PopupContent" class="PopupContent" style="background-color: white;">
        <h1 style="cursor: move;" onMouseDown="javascript: return move_popupContact(event);" onMouseMove="javascript: return movemouse(event);">Welcome to Auctus Funds GP LTD</h1>
        <p>The information provided on this website is not intended for distribution to, or use by, any person in the United States or in any jurisdiction or country where such distribution or use would be contrary to law or regulation or which would subject Auctus Funds GP LTD, its subsidiaries affiliates or related funds collectively referred to as (“AF’). The above disclaimer refers to all AF services, its affiliates and to any authorization, registration, and licensing or notification requirement within any jurisdiction in Latin America, the Caribbean, Asia or elsewhere. The website has been created for informational purposes and is intended to be accessed or used only by authorized sales representatives or current clients that are not residents of the United States.</p>
        <p>Please read this page before proceeding as it explains certain restrictions imposed by law on the distribution of this information. The information contained on this site should not be reproduced or distributed. The products described in the following pages are administered and managed by AF companies. Nothing on this website constitutes an offer to sell or a solicitation of an offer to buy any investment or insurance product that may be referred to on or through this website. Nor does this website constitute an offering or recommendation by AF to residents of any country of any security, insurance product or investment advisory service. AF is not registered as a broker-dealer in any jurisdiction and the products discussed have not been registered or approved by any central bank, governmental or regulatory authority in any jurisdiction other than Cayman Islands. Accordingly, local securities and insurance laws and other relevant laws and regulations are generally not applicable to investments in the products described on this website. It is the exclusive responsibility of the investor to consider carefully the material circumstances of each investment prior to making an investment decision. The distribution of information and offer and sale of the products referenced on or through this website may be restricted in certain jurisdictions. It is the responsibility of any persons accessing this website and any persons purchasing an investment plan to inform them of and to observe fully the applicable laws and regulations of any relevant jurisdiction. This website should not be considered as communicating any invitation or inducement to engage in investment or insurance activities. No investment advice, tax advice, or legal advice is provided through this website. You agree that this website will not be used by you for these purposes. No representation is given that the securities, products, or services discussed in or accessible through this website are suitable for you or any particular investor. You acknowledge that your use of this website and any requests for information made through this website has not been solicited by AF or any of its affiliates and that the provision of any information through this website shall not constitute or be considered investment advice. </p>
        <form name="frm-popup" id="frm-popup" method="post" action="" onsubmit="return validate();">
        <div class="FormBlock">
            <label>Name</label><span class="Required">*</span>
            <div class="clear"></div>
            <input type="text" name="name" id="name" class="name-field">
            <div class="Note">By printing your Name and checking the box below, you either accept or decline the above conditions</div>
        </div>
        <div class="FormBlock">
            <label>Disclaimer Agreement</label><span class="Required">*</span>
            <div class="clear"></div>
            <input type="radio" id="Accept" name="Disclaimer" checked="checked">
            <label for="Accept">Accept</label>
            <div class="clear"></div>
            <input type="radio" id="Decline" name="Disclaimer">
            <label for="Decline">Decline</label>
        </div>
        <div class="clear"></div>
        <input type="submit" value="Submit">
        </form>
    </div>
    <div id="PopupContent1" class="PopupContent" style="background-color: white;display: none;
    left: 458px;
    margin: auto;
    position: relative;
    top: -2px;
    z-index: 999999;">
        <h1 style="cursor: move;" onMouseDown="javascript: return move_popupContact(event);" onMouseMove="javascript: return movemouse(event);">Thank you for visiting our website.</h1>
</div>
</div>
<div class="clear"></div>