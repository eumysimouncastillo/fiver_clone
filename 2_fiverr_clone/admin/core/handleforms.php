<?php  
require_once '../classloader.php';

if (isset($_POST['insertNewUserBtn'])) {
	$username = htmlspecialchars(trim($_POST['username']));
	$email = htmlspecialchars(trim($_POST['email']));
	$contact_number = htmlspecialchars(trim($_POST['contact_number']));
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			if (!$userObj->usernameExists($username)) {

				if ($userObj->registerUser($username, $email, $password, $contact_number)) {
					header("Location: ../login.php");
				}

				else {
					$_SESSION['message'] = "An error occured with the query!";
					$_SESSION['status'] = '400';
					header("Location: ../register.php");
				}
			}

			else {
				$_SESSION['message'] = $username . " as username is already taken";
				$_SESSION['status'] = '400';
				header("Location: ../register.php");
			}
		}
		else {
			$_SESSION['message'] = "Please make sure both passwords are equal";
			$_SESSION['status'] = '400';
			header("Location: ../register.php");
		}
	}
	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}
}

if (isset($_POST['loginUserBtn'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {

        if ($userObj->loginUser($email, $password)) {

            // ✅ Check if admin
            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
                // Admin logged in
                header("Location: ../index.php?role=admin");
            } else {
                // Regular client
                header("Location: ../index.php");
            }

        } else {
            $_SESSION['message'] = "Username/password invalid";
            $_SESSION['status'] = "400";
            header("Location: ../login.php");
        }
    }

    else {
        $_SESSION['message'] = "Please make sure there are no empty input fields";
        $_SESSION['status'] = '400';
        header("Location: ../login.php");
    }
}


if (isset($_GET['logoutUserBtn'])) {
	$userObj->logout();
	header("Location: ../index.php");
}

if (isset($_POST['updateUserBtn'])) {
	$contact_number = htmlspecialchars($_POST['contact_number']);
	$bio_description = htmlspecialchars($_POST['bio_description']);
	if ($userObj->updateUser($contact_number, $bio_description, $_SESSION['user_id'])) {
		header("Location: ../profile.php");
	}
}

if (isset($_POST['insertOfferBtn'])) {
    $user_id = $_SESSION['user_id'];
    $proposal_id = $_POST['proposal_id'];
    $description = htmlspecialchars($_POST['description']);

    $result = $offerObj->createOffer($user_id, $description, $proposal_id);

    if ($result === true) {
        header("Location: ../index.php?success=1");
        exit;
    } elseif ($result === "duplicate") {
        header("Location: ../index.php?error=already_submitted");
        exit;
    } else {
        header("Location: ../index.php?error=unknown");
        exit;
    }
}

if (isset($_POST['updateOfferBtn'])) {
	$description = htmlspecialchars($_POST['description']);
	$offer_id = $_POST['offer_id'];
	if ($offerObj->updateOffer($description, $offer_id)) {
		$_SESSION['message'] = "Offer updated successfully!";
		$_SESSION['status'] = '200';
		header("Location: ../index.php");
	}
}

if (isset($_POST['deleteOfferBtn'])) {
	$offer_id = $_POST['offer_id'];
	if ($offerObj->deleteOffer($offer_id)) {
		$_SESSION['message'] = "Offer deleted successfully!";
		$_SESSION['status'] = '200';
		header("Location: ../index.php");
	}
}

// =================== ADD CATEGORY ===================
if (isset($_POST['addCategoryBtn'])) {
    $category_name = trim($_POST['category_name']);

    if (!empty($category_name)) {
        $result = $categoryObj->createCategory($category_name);

        if ($result) {
            $_SESSION['message'] = "Category added successfully!";
            $_SESSION['status'] = "200";
        } else {
            $_SESSION['message'] = "Failed to add category.";
            $_SESSION['status'] = "500";
        }
    } else {
        $_SESSION['message'] = "Category name cannot be empty.";
        $_SESSION['status'] = "400";
    }

    header("Location: ../manage_categories.php");
    exit();
}

// =================== ADD SUBCATEGORY ===================
if (isset($_POST['addSubcategoryBtn'])) {
    $category_id = trim($_POST['category_id']);
    $subcategory_name = trim($_POST['subcategory_name']);

    if (!empty($category_id) && !empty($subcategory_name)) {
        $result = $subcategoryObj->createSubcategory($category_id, $subcategory_name);

        if ($result) {
            $_SESSION['message'] = "Subcategory added successfully!";
            $_SESSION['status'] = "200";
        } else {
            $_SESSION['message'] = "Failed to add subcategory.";
            $_SESSION['status'] = "500";
        }
    } else {
        $_SESSION['message'] = "Both category and subcategory name are required.";
        $_SESSION['status'] = "400";
    }

    header("Location: ../manage_categories.php");
    exit();
}
?>