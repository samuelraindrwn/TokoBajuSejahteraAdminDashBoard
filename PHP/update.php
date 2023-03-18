<?php

$koneksi = mysqli_connect("localhost", "root", "", "toko_baju_sjhtera_db");

$id = $_GET['id'];
    
$dataByID = mysqli_query($koneksi, "SELECT * FROM product WHERE ID = '$id'");
$productbyID = $productbyID = mysqli_fetch_array($dataByID);

function isUnik($id){
    $query = mysqli_query($GLOBALS['koneksi'], "SELECT * FROM product WHERE ID = '$id'");
    if (mysqli_num_rows($query) > 0) return false;
    else return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: ../index.php');
    if(isset($_POST['btnAdd'])):
        $name = $_POST['nameAdd'];
        $type = $_POST['tipeAdd'];
        $unik = false;
        while(!$unik){
            $id = $type . "_" . rand(1, 10000);
            $unik = isUnik($id);
        }
        $price = $_POST['priceAdd'];
        $qty = $_POST['qtyAdd'];
        mysqli_query($koneksi, 
        "INSERT INTO product (ID, product_name, product_type, product_price, product_qty) 
        VALUES ('$id', '$name', '$type', '$price', '$qty') ");
    endif;

    if(isset($_POST['btnEdit'])){
        $name = $_POST['nameEdit'];
        $type = $_POST['tipeEdit'];
        $price = $_POST['priceEdit'];
        $qty = $_POST['qtyEdit'];
        mysqli_query($koneksi, 
        "UPDATE product 
        SET product_name = '$name', 
        product_type = '$type', 
        product_price = '$price', 
        product_qty = '$qty' 
        WHERE ID = '$id'");
    }

    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS -->
    <link rel="stylesheet" href="../CSS/style.css" />

    <!-- JQUERY -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>TOKO BAJU SEJAHTERA</title>
</head>

<body>
    <header>
        <a>
            <button onclick="addActive()">
                <i class="fa-sharp fa-solid fa-plus"></i> Add New Item
            </button>
        </a>
        <a href="../index.php">
            <h1>toko baju sejahtera</h1>
        </a>
    </header>

    <!-- Porduct List -->
    <main id="home">
        <?php 
        $data = mysqli_query($koneksi, "SELECT * FROM product ORDER BY product_type ASC");
        while($product = mysqli_fetch_array($data)){ ?>
        <div class="product-card">
            <div class="row">
                <h3>Id Product</h3>
                <h3>Product Name</h3>
                <h3>Type</h3>
                <h3>Price</h3>
                <h3>Quantity</h3>
            </div>
            <div class="row">
                <h3>
                    <span><?= $product['ID'] ?></span>
                </h3>
                <h3>
                    <span><?= $product['product_name'] ?></span>
                </h3>
                <h3>
                    <span><?= $product['product_type'] ?></span>
                </h3>
                <h3>
                    <span><?= 'Rp ' . number_format($product['product_price'], 0, ',', '.') ?></span>
                </h3>
                <h3>
                    <span><?= $product['product_qty'] ?></span>
                </h3>
            </div>
            <div class="row">
                <div class="btn-wrapper">
                    <a href="update.php?id=<?= $product['ID']?>">
                        <button id="editbutton">
                            <i class="fa-sharp fa-solid fa-pen-to-square"></i> Edit
                        </button>
                    </a>
                    <a>
                        <button onclick="showDelConfirm('<?= $product['ID']?>')">
                            <i class="fa-sharp fa-solid fa-trash-can"></i> Delete
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <!-- CONFIRM POP UP  -->
        <div id="del-<?= $product['ID'] ?>" class="confirm-wrapper">
            <p>Are You Sure To Delete The Product?</p>
            <div class="btn-wrapper">
                <a href="delete.php?id=<?= $product['ID']?>">
                    <button id="yes-del-<?= $product['ID'] ?>">Yes</button>
                </a>
                <a>
                    <button onclick="removeDelConfirm()">Cancel</button>
                </a>
            </div>
        </div>
        <?php }?>
    </main>

    <!-- POP UP  -->
    <div class="bg-dark active">
        <div class="add-container">
            <header>
                <h1>Add Product</h1>
            </header>
            <main class="form-wrapper">
                <form method="post">
                    <input name="nameAdd" type="text" placeholder="Product Name" required />
                    <input name="tipeAdd" type="text" placeholder="Product Type" required />
                    <input name="priceAdd" type="text" placeholder="Product Price" required />
                    <input name="qtyAdd" type="text" placeholder="Product Quantity" required />
                    <div class="btn-wrapper">
                        <a href="index.php
                        ">
                            <button name="btnAdd" type="submit">Add</button>
                        </a>
                        <a>
                            <button onclick="showAddConfirm()" type="button">cancel</button>
                        </a>
                    </div>
                </form>
            </main>
        </div>
    </div>

    <div class="edit-container">
        <header>
            <h1>Edit Product</h1>
        </header>
        <main class="form-wrapper">
            <form method="POST">
                <input name="nameEdit" type="text" value="<?= $productbyID['product_name']?>" required />
                <input name="tipeEdit" type="text" value="<?= $productbyID['product_type']?>" required />
                <input name="priceEdit" type="text" value="<?= $productbyID['product_price']?>" required />
                <input name="qtyEdit" type="text" value="<?= $productbyID['product_qty']?>" required />
                <div class="btn-wrapper">
                    <a>
                        <button name="btnEdit" type="submit">Edit</button>
                    </a>
                    <a>
                        <button onclick="showEditConfirm()" type="button">cancel</button>
                    </a>
                </div>
            </form>
        </main>
    </div>
    </div>
    <!-- CONFIRM POP UP  -->
    <div id="add" class="confirm-wrapper">
        <p>Are You Sure To Discard All The Changes?</p>
        <div class="btn-wrapper">
            <a>
                <button onclick="yesAddBtnClick()">Yes</button>
            </a>
            <a>
                <button onclick="removeAddConfirm()">Cancel</button>
            </a>
        </div>
    </div>

    <div id="edit" class="confirm-wrapper">
        <p>Are You Sure To Discard All The Changes?</p>
        <div class="btn-wrapper">
            <a>
                <button onclick="yesEditBtnClick()">Yes</button>
            </a>
            <a>
                <button onclick="removeEditConfirm()">Cancel</button>
            </a>
        </div>
    </div>

    <!-- Import JS -->
    <script src="../JS/main.js"></script>
</body>

</html>