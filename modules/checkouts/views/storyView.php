<?php get_header(); ?>

<?php 
    if (!empty($_SESSION['messa'])) {
        echo "<script>alert('Bạn cần chọn phương thức thanh toán!!!');</script>";
        unset($_SESSION['messa']);
    }

    if (!empty($_SESSION['messBuy'])) {
        echo "<script>alert('Bạn cần mua ít nhất 1 sản phẩm!!!');</script>";
        unset($_SESSION['messBuy']);
    }
?>

<div id="main-content-wp" class="checkout-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li><a href="?page=home" title="">Trang chủ</a></li>
                    <li><a href="" title="">Thanh toán</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        <form method="post" action="?modules=checkouts&controllers=index&action=checkout" name="form-checkout" id="form-checkout">
            <!-- Thông tin khách hàng -->
            <div class="section" id="customer-info-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin khách hàng</h1>
                </div>
                <div class="section-detail">
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="fullname">Họ tên</label>
                            <input type="text" name="fullname" id="fullname" value="<?php echo $_SESSION['user']['fullname'] ?? ''; ?>" required>
                        </div>
                        <div class="form-col fl-right">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="<?php echo $_SESSION['user']['email'] ?? ''; ?>" required>
                        </div>
                    </div>
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="address">Địa chỉ</label>
                            <input type="text" name="address" id="address" value="<?php echo $_SESSION['user']['address'] ?? ''; ?>" required>
                        </div>
                        <div class="form-col fl-right">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" name="phone" id="phone" value="<?php echo $_SESSION['user']['phone'] ?? ''; ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="notes">Ghi chú</label>
                        <textarea name="note" id="note"></textarea>
                    </div>
                </div>
            </div>

            <!-- Thông tin đơn hàng -->
            <div class="section" id="order-review-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin đơn hàng</h1>
                </div>
                <div class="section-detail">
                    <?php if (!empty($_SESSION['cart']['buy'])) { ?>
                        <table class="shop-table">
                            <thead>
                                <tr>
                                    <td>Sản phẩm</td>
                                    <td>Đơn giá</td>
                                    <td>Số lượng</td>
                                    <td>Tổng</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION['cart']['buy'] as $item) { ?>
                                    <tr class="cart-item">
                                        <td><?php echo $item['name']; ?></td>
                                        <td><?php echo number_format($item['price'], 0, ',', '.') . ' VND'; ?></td>
                                        <td><?php echo $item['qty']; ?></td>
                                        <td><?php echo number_format($item['sub_total'], 0, ',', '.') . ' VND'; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr class="order-total">
                                    <td colspan="3">Tổng đơn hàng:</td>
                                    <td><strong><?php echo number_format($_SESSION['cart']['info']['total'], 0, ',', '.') . ' VND'; ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    <?php } else { ?>
                        <p>Không có sản phẩm trong giỏ hàng.</p>
                    <?php } ?>
                </div>
            </div>

            <!-- Thanh toán -->
            <div id="payment-checkout-wp">
                <ul id="payment_methods">
                    <li>
                        <label for="payment-home">
                            <input type="radio" id="payment-home" name="payment_method" value="home_payment" required>
                            Thanh toán tại nhà
                        </label>
                    </li>
                </ul>
            </div>

            <!-- Nút đặt hàng -->
            <div class="place-order-wp clearfix">
                <button type="submit" id="order-now">Đặt hàng</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById("form-checkout").addEventListener("submit", async function (event) {
        event.preventDefault();
        const formData = new FormData(this);

        try {
            const response = await fetch(this.action, {
                method: this.method,
                body: formData,
            });

            if (response.ok) {
                const result = await response.json();
                if (result.success) {
                    alert("Đặt hàng thành công!");
                    window.location.href = "?modules=checkouts&controllers=index&action=story";
                } else {
                    alert(result.message || "Đặt hàng không thành công. Vui lòng thử lại!");
                }
            } else {
                throw new Error("HTTP Error: " + response.status);
            }
        } catch (error) {
            console.error("Đã xảy ra lỗi:", error);
            alert("Đặt hàng không thành công. Vui lòng thử lại!");
        }
    });
</script>

<?php get_footer(); ?>