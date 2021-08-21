<?php

    namespace App\Controllers;

    use App\core\base\Controller;
    use App\core\Application;
    use App\core\http\Response;
    use App\models\Orders;
    use App\models\Food;
    use App\models\Extras;

    class OrdersController extends Controller {


        public function actionAdd() {
            
            $user_id = $_REQUEST['user_id'];
            
            
            $order_obj = new Orders();
            $order = $order_obj->getUserOrderByName($user_id, $_REQUEST['order']);

            
            if(!empty($order)) {

                if($order['is_extra'] == 1) {
                    $extra = new Extras();

                    $price = $extra->getPriceByName($_REQUEST['order']);

                    $order_obj->increaseOrderQuantity($order['order_id'], $price);
                    die();
                }
                else {

                    $food = new Food();

                    $price = $food->getActualPriceByName($_REQUEST['order']);

                    $order_obj->increaseOrderQuantity($order['order_id'], $price);
                    die();
                }
            }
            
            $order = $_REQUEST['order'];
            $is_extra = "DEFAULT";
            
            if(isset($_REQUEST['is_extra']) && $_REQUEST['is_extra'] === "1") {
                $is_extra = 1;
                $extra = new Extras();
                $price = $extra->getPriceByName($_REQUEST['order']);
                $price_no_discount = $price;
            }
            else {
                $food = new Food();

                if($order_obj->UserHasAFoodSelected($user_id)) {
                    $price = $food->getActualPriceByName($_REQUEST['order']);
                }
                else {
                    $price = $food->getDiscountPriceByName($_REQUEST['order']);
                }
                $price_no_discount = $food->getActualPriceByName($_REQUEST['order']);
            }

            
            $order = new Orders([null, $user_id, $order, "DEFAULT", "DEFAULT", $price, $price_no_discount, $is_extra]);

            $order->save();

            die();

        }

        public function actionGetbyuser() {

            $user_id = $_REQUEST['user_id'];

            $orders = new Orders();

            $orders = $orders->getOrdersByUser($user_id);


            echo json_encode($orders);
        }

        public function actionDelete() {

            $order_id = $_REQUEST['order_id'];
            $order_obj = new Orders();
            $order = Application::$db->row("SELECT * FROM orders WHERE order_id=$order_id");
            $user_id = $order['user_id'];


            if($order['is_extra'] == 1) {

                if($order['quantity'] == 1) {
                    $order_obj->delete($order_id);
                    die();
                }
                else if($order['quantity'] > 1) {
                    $extra_price = Application::$db->row("SELECT price FROM extras WHERE extra=:extra", ['extra' => $order['order_']]);
                    $extra_price = $extra_price['price'];
                    Application::$db->execute("UPDATE orders SET quantity=quantity - 1, price=price - $extra_price, price_no_discount=price_no_discount - $extra_price WHERE order_id=$order_id");
                    die();
                }

            }
            else if ($order['is_extra'] == 0) {

                $food = new Food();
                $actual_price = $food->getActualPriceByName($order['order_']);
                $discount_price = $food->getDiscountPriceByName($order['order_']);

                if($order['quantity'] == 1) {

                    $order_obj->delete($order_id);
                    if($order['price'] == $actual_price) die();



                    $date = date('Y-m-d');
                    $other_order = Application::$db->row("SELECT * FROM orders WHERE user_id=$user_id AND is_extra=0 AND date='$date'");

                    if(!empty($other_order)) {
                        $order_id = $other_order['order_id'];
                        Application::$db->execute("UPDATE orders SET price=price - $actual_price + $discount_price WHERE order_id=$order_id");
                    }
                    die();
                }
                else if($order['quantity'] > 1) {
                    Application::$db->execute("UPDATE orders SET quantity=quantity - 1, price=price - $actual_price, price_no_discount=price_no_discount - $actual_price WHERE order_id=$order_id");
                    die();
                }

            }


        }

        public function actionGetweekordersbyuser() {

            $orders = new Orders();

            $user_id = $_REQUEST['user_id'];

            $orders = $orders->getWeekOrdersByUser($user_id);

            echo json_encode($orders);

        }

        public function actionGetweekorders() {

            $orders = new Orders();

            $orders = $orders->getWeekOrders();

            echo json_encode($orders);

        }
        
        public function actionGetordersdata() {

            $orders_data = new Orders();

            $orders_data = $orders_data->getOrdersData();

            echo json_encode($orders_data);
        }
        
        public function actionMakeorder() {

            $orders_data = new Orders();

            $orders_data = $orders_data->makeOrder();

            echo json_encode($orders_data);
        }
        











    }





?>