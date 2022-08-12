package main

import (
	"encoding/json"
	"fmt"
	"net/http"
	"net/url"
	"strconv"
)

type PriceVariants struct {
	Price_purchase float64 `json:"price_purchase"`
	Price_selling  float64 `json:"price_selling"`
	Price_discount float64 `json:"price_discount"`
}

type Product struct {
	Product_id int                    `json:"product_id"`
	Prices     map[string]interface{} `json:"prices"`
}

const api_url = "http://127.0.0.1:888/api"
const api_key = "kt_api_key_md5_hash"

func main() {
	products := []Product{}

	var product_id int = 1001000

	var price_purchase float64 = 1000
	var price_selling float64 = 1200
	var price_discount float64 = 1100

	for i := 1; i <= 1000; i++ {
		product_id++

		region_price := map[string]interface{}{}
		for r := 1; r <= 20; r++ {
			price_purchase = inc(price_purchase)
			price_selling = inc(price_selling)
			price_discount = inc(price_discount)

			region_price[strconv.Itoa(r)] = PriceVariants{price_purchase, price_selling, price_discount}
		}
		p := Product{product_id, region_price}

		products = append(products, p)
	}

	b, err := json.Marshal(products)
	if err != nil {
		fmt.Println(err)
	}

	formData := url.Values{
		"key":  {api_key},
		"data": {string(b)},
	}

	resp, err := http.PostForm(api_url, formData)
	if err != nil {
		fmt.Println(err)
	}

	fmt.Println(resp)
}

func inc(price float64) float64 {
	var i float64 = 1
	return price + i
}
