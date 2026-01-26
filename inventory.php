<?php
declare(strict_types=1);
require 'vendor/autoload.php';

//parent
class Product {
    protected string $name;
    protected float $price;
    protected int $stock;
    protected string $category;

    public function __construct(string $name, float $price, int $stock, string $category) {
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->category = $category;
    }

    
    public function getName(): string {
         return $this->name; }

    public function getPrice(): float {
         return $this->price; }

    public function getStock(): int {
         return $this->stock; }

    public function getCategory(): string {
         return $this->category; }

    
    public function setStock(int $amount): void {
        if ($amount < 0) {
            echo "!!! ERROR: Stock for cannot be negative !!!\n";
        } else {
            $this->stock = $amount;
        }
    }

    public function setPrice(float $newPrice): void {
    if ($newPrice > 0) {
        $this->price = $newPrice;
    } else {
        echo "Error: Price must be positive.\n";
    }
}
    public function getProductType(): string {
        return "Physical Hardware";
    }
}

//child
class SoftwareProduct extends Product {
    public function getProductType(): string {
      return "Software Product";  
    }
}

// Initial Data
$my_stock = [
    new Product("M5 Macbook Air", 120000.0, 20, "Laptop"),
    new Product("Samsung Galaxy S25 Ultra", 110000.0, 15, "Smartphone"),
    new Product("OnePlus 12R", 45000.0, 30, "Smartphone"),
    new Product("Dell XPS 15", 150000.0, 10, "Laptop"),
    new Product("Logitech MX Master 3S", 12000.0, 50, "Accessories"),
    new SoftwareProduct("Microsoft Office 365 Full Suite", 20000.0, 12, "Software"),
    new SoftwareProduct("Windows 11 Pro", 20000.0,1000, "Software" ),
];

// Interactive Menu
while (true) {
    echo "\n--- INVENTORY SYSTEM ---\n";
    echo "1. View All Products\n";
    echo "2. Search & Edit\n";
    echo "3. Filter by Category\n";
    echo "4. Add New Product\n";
    echo "5. Exit The System\n";
    echo "Selection: ";

    $choice = trim(fgets(STDIN));

    
    switch ($choice) {
        
        case "1": // VIEW ALL
            echo "\n" . str_repeat("-", 80) . "\n"; 
            foreach ($my_stock as $item) {
                echo "[" . $item->getProductType() . "] " . 
                     str_pad($item->getName(), 30) . " | " . 
                     str_pad("CATEGORY: " . $item->getCategory(), 15) . " | " . 
                     "STOCK: " . str_pad((string)$item->getStock(), 5) . " | " . 
                     "KES " . number_format($item->getPrice()) . "\n";
            }
            echo str_repeat("-", 80) . "\n";
            break; 

        case "2": // SEARCH & EDIT
            echo "Enter product name to search: ";
            $search = trim(fgets(STDIN));
            $found = false;

            foreach ($my_stock as $product) {
                if (stripos($product->getName(), $search) !== false) {
                    $found = true;
                    echo "\nFound: " . $product->getName() . "\n";
                    echo "1. Edit Price | 2. Edit Stock | 3. Cancel\nSelection: ";
                    $editChoice = trim(fgets(STDIN));

                    
                    switch ($editChoice) {
                        case "1":
                            echo "Enter new price: ";
                            $newPrice = (float)trim(fgets(STDIN));
                            $product->setPrice($newPrice);
                            break;
                        case "2":
                            echo "Enter new stock: ";
                            $newStock = (int)trim(fgets(STDIN));
                            $product->setStock($newStock);
                            break;
                    }
                }
            }
            if (!$found) echo "Product not found.\n";
            break;

        case "3": // FILTER BY CATEGORY
            echo "Enter category: ";
            $cat = trim(fgets(STDIN));
            
            // This is the Anonymous Function part
            $filtered = array_filter($my_stock, function($p) use ($cat) {
                return strtolower($p->getCategory()) === strtolower($cat);
            });

            echo "\n--- Results for {$cat} ---\n";
            foreach ($filtered as $item) {
                echo $item->getName() . " | Stock: " . $item->getStock() . "\n";
            }
            break;

        case "4":
            echo "\n--- ADDING NEW PRODUCT ---\n";
            echo "Type: 1. Hardware | 2. Software: ";
            $type = trim(fgets(STDIN));
            
            echo "Name: ";
            $name = trim(fgets(STDIN));
            echo "Price (KES): ";
            $price = (float)trim(fgets(STDIN));
            echo "Initial Stock: ";
            $stock = (int)trim(fgets(STDIN));
            echo "Category: ";
            $cat = trim(fgets(STDIN));

            if ($type === "2") {
                $my_stock[] = new SoftwareProduct($name, $price, $stock, $cat);
            } else {
                $my_stock[] = new Product($name, $price, $stock, $cat);
            }
            echo "Successfully added $name to the session!\n";
            break;

        case "5": // EXIT
            echo "Exiting system......Thank you for using the system!\n";
            break 2; 

        default: // INVALID INPUT
            echo "Invalid selection. Please enter 1, 2, 3, or 4.\n";
            break;
    }
}