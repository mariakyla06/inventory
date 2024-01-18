<?php

Class Order extends Model {

    protected $table = 'orders';

    public function getOrders(){
        return $this->setQuery("SELECT
                                    A.*,
                                    B.productName as product_name,
                                    B.barcodeId as barcode_id,
                                    C.name as ordered_by_name
                                    FROM `orders` as A
                                    LEFT JOIN `product` as B
                                    ON A.product_id = B.id
                                    LEFT JOIN `clients` as C
                                    ON A.ordered_by = C.id
                                    AND  A.deleted_at IS NULL
                                    ORDER BY A.created_at DESC
                                    ")
                            ->getAll();
    }
    public function getApprovedOrders(){
        return $this->setQuery("SELECT
                                    A.*,
                                    B.productName as product_name,
                                    B.barcodeId as barcode_id,
                                    C.name as ordered_by_name
                                    FROM `orders` as A
                                    LEFT JOIN `product` as B
                                    ON A.product_id = B.id
                                    LEFT JOIN `clients` as C
                                    ON A.ordered_by = C.id
                                    AND  A.deleted_at IS NULL
                                    WHERE A.status = 'APPROVED';
                                    ORDER BY A.created_at DESC
                                    ")
                            ->getAll();
    }
    public function getUserOrders($id){
        return $this->setQuery("SELECT
                                    A.*,
                                    B.productName as product_name,
                                    B.barcodeId as barcode_id,
                                    C.name as ordered_by_name
                                    FROM `orders` as A
                                    LEFT JOIN `product` as B
                                    ON A.product_id = B.id
                                    LEFT JOIN `clients` as C
                                    ON A.ordered_by = C.id
                                    AND  A.deleted_at IS NULL
                                    WHERE C.id = $id
                                    ORDER BY A.created_at DESC
                                    ")
                            ->getAll();
    }
 

}