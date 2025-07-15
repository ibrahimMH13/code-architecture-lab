<?php




interface Logger{
    public function log(array $data);
}

interface Validate{
    public function validate(array $data);
}

interface DB{
    public function connect();
}

interface Notifier {
    public function notify(array $data);
}
interface IEmailNotifier extends Notifier {
  
}

class EmailNotifier implements IEmailNotifier{
    public function notify(array $data){
        $to = $orderData['user_email'];
        $subject = "Order Confirmation";
        $message = "Thank you for your order!";
        mail($to, $subject, $message);
    }

}
interface IBaseRepository {
    public function query(array $data);
}

 class BaseRepository implements IBaseRepository, DB{

        protected $db;
        protected string $table;
        public function __construct(){
            $this->db = new PDO('mysql:host=localhost;dbname=shop', 'root', '');
        }

        public function query(array $data) {
            $columns = implode(',', array_keys($data));
            $placeholders = implode(',', array_fill(0, count($data), '?'));
            $stmt = $this->db->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
            $stmt->execute(array_values($data));
        }
}

 class OrderRepository extends BaseRepository{

    public function __construct(){
        $table->table = 'orders';
    }
 }


 class OrderValidator implements Validate {
    public function validate(array $data) {
        if (empty($data['product_id']) || empty($data['user_id'])) {
            throw new Exception("Invalid order data");
        }
    }
}

class FileLogger implements Logger{

    public function log(array $data){
        file_put_contents('app.log',json_encode($data),FILE_APPEND);
    }
}



class OrderService {

    public function __construct(protected Logger $logger,protected Validate $validator,protected Notifier $notifier, protected OrderRepository $orderRepository){}

    public function placeOrder(array $data){
        $this->validator->validate($data);
        $this->orderRepository->query($data);
        $this->logger->log(['status' => 'Order created']); 
        $this->notifier->notify($data);
    }
}
