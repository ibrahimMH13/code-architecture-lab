<?php

    interface Observer{

        public function update(array $data);
    }

    interface   IObserverable{
        public function attach(Observer $observer);
    } 


    class SmsNotifer implements Observer{

        public function update(array $data){
                echo "sending sms ...\n";
        }
    }

    class EmailNotifer implements Observer{
        public function update(array $data){
            echo "sending email ...\n";
        }
    }

    class PushNotifer implements Observer{
        public function update(array $data){    
            echo "sending push ...\n";
        }
    }

    class NewsAgency implements IObserverable{

        protected array $observers = [];

        public function attach(Observer $observer){
            $this->observers[] = $observer;
        }

        public function notify(array $data){
            foreach($this->observers as $observer){
                $observer->update($data);
            }
        }
    }

    $breackingNews = new NewsAgency();
    $breackingNews->attach(new SmsNotifer);
    $breackingNews->attach(new EmailNotifer);
    $breackingNews->attach(new PushNotifer);

    $breackingNews->notify(["Hello, Ibrahim, Nice to meet you"]);