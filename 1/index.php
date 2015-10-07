<?php
    $total = 0;
	$summary = "";
  //Handle the form
    function validateFeedbackForm($arr) {
        extract($arr);

        if(!isset($inputName, $inputEmail, $inputPhone, $inputStreet, $selectProvince, $inputCity, $inputPostalCode)) return;

        if(!$inputName) {
          return "Please enter your name";
        }
		
		if(!$inputPhone) {
          return "Please enter your telephone number";
        }
		
		if(!preg_match("/\w+@\w+\.\w+/", $inputEmail)) {
          return "Please enter a valid email address";
        }
		
		if(!$inputStreet) {
          return "Please enter your street number and street name";
        }
		
		if(!$selectProvince) {
          return "Please select your Province";
        }
		
		if(!$inputCity) {
          return "Please enter your City";
        }
		
		if(!preg_match("/[A-Z]{1}\d{1}[A-Z]{1}\s\d{1}[A-Z]{1}\d{1}/", $inputPostalCode)) {
          return "Please enter your Postal Code";
        }

    }

    function calculateTotal(){
		global $total, $summary;
		
		$pizzaSize = $_POST["radioPizzaSize"];	
		switch ($pizzaSize){
			case "Small":
				$total += 5;
				break;
			case "Med":
				$total += 10;
				break;
			case "Large":
				$total += 15;
				break;
			case "XL":
				$total += 20;
				break;			
        }
		
		if (isset($_POST["radioCrustType"])){
			if ($_POST["radioCrustType"] == 'Stuffed'){
				$total += 2;
			}
		}
		
		$sum = sumToppings();
		
		if ($sum > 0){
			$total += $sum * 0.5;
		}
		
		getTaxes();
		
		$summary .= "<p>Your total is CAD$".number_format($total, 2)."</p>";
		$summary .= "Test";

		return $summary;
    }
	
	function getTaxes(){
		global $total;
		if (isset($_POST["selectProvince"])){
			switch($_POST["selectProvince"]){
				case "ON":
					$total = $total * 1.13;
					break;
				case "QC":
					$total = $total * 1.14975;
					break;
				case "MB":
					$total = $total * 1.08;
					break;
				case "SK":
					$total = $total * 1.10;
					break;
			}
		}
	}
	
	function sumToppings(){
		$count = 0;
		if(!empty($_POST['toppings'])) {
			foreach($_POST['toppings'] as $check) {
				$count++;
			}
		}
		if ($count > 1){
			$count--;
		}
		
		return $count;
	}
	
	function checkToppings($value){
		if(!empty($_POST['toppings'])) {
			foreach($_POST['toppings'] as $check) {
				if ($check == $value){
					return " checked";
				}
			}
		}
		
		return " ";
	}

    if(isset($_POST['buttonOrder'])) {
        $errorMsg = validateFeedbackForm($_POST);
		if (!isset($errorMsg)){
			$summary = calculateTotal();
		}
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Conestoga Pizzeria - Assignment 1</title>
		<link type="text/css" rel="stylesheet" href="css/style.css"/> 
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="js/validation.js"></script>
		<script src="js/javascript.js"></script>
	</head>
	<body>
        <div id="logo">
			<p>
				Conestoga Pizzeria
			</p>
        </div>
        <form id="order" method="POST" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" accept-charset="UTF-8">
            <div class="container">
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-12">
						<?php
							if(isset($errorMsg) && $errorMsg) {
							  echo "<p class=\"alert alert-warning\">", htmlspecialchars($errorMsg), "</p>\n\n";
							}
						?>
						<fieldset> <legend>Personal Information</legend>
							<div id="personName">
								<label class="control-label" for="inputName">Name</label>
								<input type="text" class="form-control" id="inputName" name="inputName" 
									value="<?php if(isset($_POST['inputName'])) echo htmlspecialchars($_POST['inputName']); ?>">
							</div>
							<div id="phone">
								<label class="control-label" for="inputPhone">Telephone</label>
								<input type="text" class="form-control" id="inputPhone" name="inputPhone" size="13"
									value="<?php if(isset($_POST['inputPhone'])) echo htmlspecialchars($_POST['inputPhone']); ?>">
							</div>
							<div id="email">
								<label class="control-label" for="inputEmail">Email address</label>
								<input type="email" class="form-control" id="inputEmail" name="inputEmail"
									value="<?php if(isset($_POST['inputEmail'])) echo htmlspecialchars($_POST['inputEmail']); ?>">
							</div>
							<fieldset> <legend>Address</legend>
								<div id="street">
									<label class="control-label" for="inputStreet">Street</label>
									<input type="text" class="form-control" id="inputStreet" name="inputStreet"
										value="<?php if(isset($_POST['inputStreet'])) echo htmlspecialchars($_POST['inputStreet']); ?>">
								</div>
								<div id="province">
									<label class="control-label" for="selectProvince">Province</label>
									<select id="selectProvince" name="selectProvince" class="form-control">
										<option value="0" <?php if(isset($_POST['selectProvince']) && $_POST['selectProvince'] == '0') echo 'selected'; ?>>Select</option>
										<option value="QC" <?php if(isset($_POST['selectProvince']) && $_POST['selectProvince'] == 'QC') echo 'selected'; ?>>QC</option>
										<option value="MB" <?php if(isset($_POST['selectProvince']) && $_POST['selectProvince'] == 'MB') echo 'selected'; ?>>MB</option>
										<option value="ON" <?php if(isset($_POST['selectProvince']) && $_POST['selectProvince'] == 'ON') echo 'selected'; ?>>ON</option>
										<option value="SK" <?php if(isset($_POST['selectProvince']) && $_POST['selectProvince'] == 'SK') echo 'selected'; ?>>SK</option>	
									</select>
								</div>
								<div id="city">
									<label class="control-label" for="inputCity">City</label>
									<input type="text" class="form-control" id="inputCity" name="inputCity"
										value="<?php if(isset($_POST['inputCity'])) echo htmlspecialchars($_POST['inputCity']); ?>">
								</div>
								<div id="postal">
									<label class="control-label" for="inputPostalCode">Postal Code</label>
									<input type="text" class="form-control" id="inputPostalCode" name="inputPostalCode" size="7"
										value="<?php if(isset($_POST['inputPostalCode'])) echo htmlspecialchars($_POST['inputPostalCode']); ?>">
								</div>
							</fieldset>
						</fieldset>	
				    </div>
				<div class="form-group col-lg-6 col-sm-12">
                    <fieldset> <legend>Order Information</legend>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label>Pizza size</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="radioPizzaSize" id="small" value="Small" checked> Small
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="radioPizzaSize" id="med" value="Med" <?php if(isset($_POST['radioPizzaSize']) && $_POST['radioPizzaSize'] == 'Med') echo 'checked'; ?>> Medium
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="radioPizzaSize" id="large" value="Large" <?php if(isset($_POST['radioPizzaSize']) && $_POST['radioPizzaSize'] == 'Large') echo 'checked'; ?>> Large
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="radioPizzaSize" id="xl" value="XL" <?php if(isset($_POST['radioPizzaSize']) && $_POST['radioPizzaSize'] == 'XL') echo 'checked'; ?>> X-Large
                                </label>
                            </div>
                            <label>Crust Type</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="radioCrustType" id="hand-tossed" value="Hand-tossed" checked> Hand-tossed
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="radioCrustType" id="pan" value="Pan" <?php if(isset($_POST['radioCrustType']) && $_POST['radioCrustType'] == 'Pan') echo 'checked'; ?>> Pan
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="radioCrustType" id="stuffed" value="Stuffed" <?php if(isset($_POST['radioCrustType']) && $_POST['radioCrustType'] == 'Stuffed') echo 'checked'; ?>> Stuffed
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="radioCrustType" id="thin" value="Thin" <?php if(isset($_POST['radioCrustType']) && $_POST['radioCrustType'] == 'Thin') echo 'checked'; ?>> Thin
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label>Toppings</label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="bacon" value="Bacon" name="toppings[]" <?php echo checkToppings('Bacon'); ?>> Bacon crumble
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="salami" value="Salami" name="toppings[]" <?php echo checkToppings('Salami'); ?>> Salami
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="peperoni" value="Peperoni" name="toppings[]" <?php echo checkToppings('Peperoni'); ?>> Peperoni
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="ham" value="Ham" name="toppings[]" <?php echo checkToppings('Ham'); ?>> Ham
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="mozzarella" value="Mozzarella" name="toppings[]" <?php echo checkToppings('Mozzarella'); ?>> Mozzarella
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="extraCheese" value="ExtraCheese" name="toppings[]" <?php echo checkToppings('ExtraCheese'); ?>> Extra Cheese
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="tomato" value="Tomato" name="toppings[]" <?php echo checkToppings('Tomato'); ?>> Tomato
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="olives" value="Olives" name="toppings[]" <?php echo checkToppings('Olives'); ?>> Olives
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="broccoli" value="Broccoli" name="toppings[]" <?php echo checkToppings('Broccoli'); ?>> Broccoli
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="garlicSauce" value="GarlicSauce" name="toppings[]" <?php echo checkToppings('GarlicSauce'); ?>> Garlic Sauce
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="tomatoSauce" value="TomatoSauce" name="toppings[]" <?php echo checkToppings('TomatoSauce'); ?>> Tomato Sauce
                                </label>
                            </div>
                            <div id="toppingMessage" class="hidden alert alert-warning">
                                You didn't selected any topping! Just to remind you: one topping is free!
                            </div>
                        </div>
                    </fieldset>
				    </div>
				    <div class="form-group col-lg-12 col-sm-12 text-right">
					   <button type="submit" class="btn btn-success" id="buttonOrder" name="buttonOrder">Order</button>
				    </div>
                    <div class="form-group col-lg-12 col-sm-12 text-center alert alert-info">
                        <?php
							if(isset($summary) && $summary) {
                              echo "<h1>SUMMARY</h1>". $summary."\n\n";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </form>
	</body>
</html>