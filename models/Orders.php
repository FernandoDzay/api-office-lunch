<?php

    namespace App\models;

    use App\core\base\Model;
    use App\core\Application;

    class Orders extends Model {


        private $response_ok;
        private $response_not_ok;



        public function my_construct() {
            $this->response_ok = json_encode(['response' => "true"]);
            $this->response_not_ok = json_encode(['response' => "false"]);
        }

        public function response_ok() {
            echo $this->response_ok;
            die();
        }

        public function response_not_ok() {
            http_response_code ( 404 );
            echo $this->response_not_ok;
            die();
        }

        public function getUserOrderByName($user_id, $name) {
            $order = Application::$db->row('SELECT * FROM orders WHERE user_id = :user_id AND order_=:order AND date=:date', ['user_id' => $user_id, 'order' => $name, 'date' => date("Y-m-d")]);
            return $order;
        }

        public function increaseOrderQuantity($order_id, $price) {
            Application::$db->execute("UPDATE orders SET quantity = quantity + 1, price = price + :price, price_no_discount = price_no_discount + :price WHERE order_id=:order_id", ['order_id' => $order_id, 'price' => $price]);
        }

        public function UserHasAFoodSelected($user_id) {
            $orders = Application::$db->row('SELECT * FROM orders WHERE user_id = :user_id AND is_extra=0 AND date=:date', ['user_id' => $user_id, 'date' => date("Y-m-d")]);

            if( empty($orders) ) {
                return false;
            }
            else {
                return true;
            }
        }

        public function getOrdersByUser($user_id) {

            $date = date("Y-m-d");

            $sql = "SELECT * FROM orders WHERE user_id=:user_id AND date='$date'";

            $orders = Application::$db->query($sql, ['user_id' => $user_id]);


            return $orders;

        }

        public function getWeekOrdersByUser($user_id) {

            if( isset($_REQUEST['date']) ) $date = Application::$app->GlobalFunctions->getMonday($_REQUEST['date']);
            else $date = Application::$app->GlobalFunctions->getMonday();

            $query = 
            "
                SELECT order_, date, quantity, price FROM orders
                WHERE user_id=:user_id
                AND date >= :date
                AND DATE <= DATE_ADD(:date, interval 4 DAY)
                ORDER BY date, is_extra
            ";

            $query_data = Application::$db->query($query, ['user_id' => $user_id, 'date' => $date]);

            $week_orders = [
                'lunes' => [],
                'martes' => [],
                'miercoles' => [],
                'jueves' => [],
                'viernes' => [],
            ];

            foreach($query_data as $key => $value) {

                $temp_array = [
                    'order' => $value['order_'],
                    'quantity' => $value['quantity'],
                    'price' => $value['price'],
                ];

                array_push( $week_orders[Application::$app->GlobalFunctions->transformDateToDay($value['date'])], $temp_array );
            }


            return $week_orders;

        }

        public function getWeekOrders() {

            if( isset($_REQUEST['date']) ) $date = Application::$app->GlobalFunctions->getMonday($_REQUEST['date']);
            else $date = Application::$app->GlobalFunctions->getMonday();
            
            $query = 
            "
                SELECT username, order_, quantity, price, price_no_discount, date FROM orders o
                INNER JOIN users u ON o.user_id = u.id
                WHERE date >= :date
                AND date <= DATE_ADD(:date, interval 4 DAY)
                ORDER BY date, username, is_extra
            ";

            $query_data = Application::$db->query($query, ['date' => $date]);

            $week_orders = [
                'lunes' => [],
                'martes' => [],
                'miercoles' => [],
                'jueves' => [],
                'viernes' => [],
            ];

            foreach($query_data as $key => $value) {

                $user_data = [
                    'order' => $value['order_'],
                    'quantity' => $value['quantity'],
                    'price' => $value['price'],
                    'price_no_discount' => $value['price_no_discount']
                ];

                $day = Application::$app->GlobalFunctions->transformDateToDay($value['date']);

                if( isset($week_orders[$day][$value['username']]) ) {
                    array_push( $week_orders[$day][$value['username']], $user_data );
                }
                else {
                    $week_orders[$day][$value['username']][0] = $user_data;
                }

            }
            
            return $week_orders;

        }

        public function getOrdersData() {
            if( isset($_REQUEST['date']) ) $date = Application::$app->GlobalFunctions->getMonday($_REQUEST['date']);
            else $date = Application::$app->GlobalFunctions->getMonday();

            $query = 
            "
                SELECT order_, sum(quantity) AS quantity, sum(price) AS price, sum(price_no_discount) AS price_no_discount, is_extra, date
                FROM orders WHERE
                date >= :date
                AND date <= DATE_ADD(:date, interval 4 DAY)
                GROUP BY order_, date
                ORDER BY date, is_extra
            ";

            $query_data = Application::$db->query($query, ['date' => $date]);

            $orders_data = [
                'total_to_pay' => 0,
                'users_total_to_pay' => 0,
                'days' => [
                    'lunes' => [
                        'total_to_pay' => 0,
                        'users_total_to_pay' => 0,
                        'quantity_data' => []
                    ],
                    'martes' => [
                        'total_to_pay' => 0,
                        'users_total_to_pay' => 0,
                        'quantity_data' => []
                    ],
                    'miercoles' => [
                        'total_to_pay' => 0,
                        'users_total_to_pay' => 0,
                        'quantity_data' => []
                    ],
                    'jueves' => [
                        'total_to_pay' => 0,
                        'users_total_to_pay' => 0,
                        'quantity_data' => []
                    ],
                    'viernes' => [
                        'total_to_pay' => 0,
                        'users_total_to_pay' => 0,
                        'quantity_data' => []
                    ]
                ]
            ];

            foreach($query_data as $key => $order) {
                $day = Application::$app->GlobalFunctions->transformDateToDay($order['date']);
                $orders_data['days'][$day]['quantity_data'][] = [
                    'order' => $order['order_'],
                    'quantity' => $order['quantity'],
                    'is_extra' => $order['is_extra']
                ];

                $orders_data['days'][$day]['total_to_pay'] += $order['price_no_discount'];
                $orders_data['days'][$day]['users_total_to_pay'] += $order['price'];
                $orders_data['total_to_pay'] += $order['price_no_discount'];
                $orders_data['users_total_to_pay'] += $order['price'];
            }

            return $orders_data;
        }

        public function makeOrder() {
            $date = date('Y-m-d');

            $query = 
            "
                SELECT order_, short_name, sum(quantity) AS quantity, sum(price) AS price, sum(price_no_discount) AS price_no_discount, is_extra, date
                FROM orders 
                INNER JOIN foods on food = order_
                WHERE
                date = :date
                GROUP BY order_
                
                UNION
                
                SELECT order_, order_ AS short_name, sum(quantity) AS quantity, SUM(o.price) AS price, sum(price_no_discount) AS price_no_discount, is_extra, date
                FROM orders o
                INNER JOIN extras on extra = order_
                WHERE
                date = :date
                GROUP BY order_
                ORDER BY is_extra, order_
            ";

            $orders_data = [
                'total_to_pay' => 0,
                'orders' => Application::$db->query($query, ['date' => $date])
            ];
            

            foreach($orders_data['orders'] as $key => $order) {
                $orders_data['total_to_pay'] += $order['price_no_discount'];
            }

            return $orders_data;
        }

        

    


        //-------------------------------------------------
        public function setBaseColumn() {
            return 'order_id';
        }

        public function setTableName() {
            return 'orders';
        }

        public function setTableColumns() {
            return [
                'order_id',
                'user_id',
                'order_',
                'quantity',
                'date',
                'price',
                'price_no_discount',
                'is_extra'
            ];
        }
    }



?>