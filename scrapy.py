import requests

BASE_URL = "https://taobao.com"

def order_item(name, count):
    pass

def get_price(name):
    pass

def scrapy():
    order_products = {
        "6476101": 2,
        "6463071": 1,
        "6703851": 2,
        "6731991": 10,
        "6720691": 2,
        "6713521": 1,
    }
    # Step 1
    for product, count in order_products:
        order_item(name=product, count=count)

    # Step 2
    new_products = ["6517881", "M375781"]
    for product in new_products:
        get_price(product)

    # Step 3
    """
    Define a function that gets a product from given information.
    For example
    buy_product(sex="male", title="summer sports clothes", sizes=[150, 160])
    buy_product(sex="male", title=["spring clothes", "sprint trousers"], sizes=[150, 160])
    buy_product(sex="female", title=["watch", "trousers", "shirts", "suit"])
    """

if __name__ == "__main__":
    scrapy()