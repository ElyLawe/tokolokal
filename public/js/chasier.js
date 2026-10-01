let cart = [];


/*
|--------------------------------------------------------------------------
| FORMAT RUPIAH
|--------------------------------------------------------------------------
*/

function formatRupiah(value)
{
    return new Intl.NumberFormat(
        'id-ID',
        {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }
    ).format(value || 0);
}


/*
|--------------------------------------------------------------------------
| SEARCH PRODUCT
|--------------------------------------------------------------------------
*/

const searchInput =
    document.getElementById('searchProduct');

const resultBox =
    document.getElementById('productResults');


function searchProduct()
{
    const keyword =
        searchInput.value.toLowerCase().trim();

    if (!keyword)
    {
        resultBox.style.display = 'none';
        return;
    }

    const results = products.filter(product => {

        const name =
            String(product.name || '')
                .toLowerCase();

        const category =
            String(product.category || '')
                .toLowerCase();

        return (
            name.includes(keyword) ||
            category.includes(keyword)
        );

    });


    if (results.length === 0)
    {
        resultBox.innerHTML = `
            <div class="product-item">
                Barang tidak ditemukan
            </div>
        `;
    }
    else
    {
        resultBox.innerHTML = results.map(product => `
            <div
                class="product-item"
                onclick="addToCart(${product.id})"
            >

                <div>

                    <div class="product-name">
                        ${product.name}
                    </div>

                    <div class="product-code">
                        ${product.category || '-'}
                        • Stok ${product.stock}
                    </div>

                </div>

                <div class="product-price">
                    ${formatRupiah(product.price)}
                </div>

            </div>
        `).join('');
    }


    resultBox.style.display = 'block';
}


/*
|--------------------------------------------------------------------------
| INPUT SEARCH
|--------------------------------------------------------------------------
*/

searchInput.addEventListener(
    'input',
    searchProduct
);


/*
|--------------------------------------------------------------------------
| ADD TO CART
|--------------------------------------------------------------------------
*/

function addToCart(productId)
{
    const product =
        products.find(
            product => product.id == productId
        );


    if (!product)
    {
        return;
    }


    const existing =
        cart.find(
            item => item.id == productId
        );


    if (existing)
    {
        if (existing.qty < product.stock)
        {
            existing.qty++;
        }
        else
        {
            alert('Jumlah melebihi stok.');
            return;
        }
    }
    else
    {
        cart.push({
            id: product.id,
            name: product.name,
            price: Number(product.price),
            stock: Number(product.stock),
            qty: 1
        });
    }


    searchInput.value = '';

    resultBox.style.display = 'none';

    renderCart();
}


/*
|--------------------------------------------------------------------------
| RENDER CART
|--------------------------------------------------------------------------
*/

function renderCart()
{
    const body =
        document.getElementById('cartBody');


    if (cart.length === 0)
    {
        body.innerHTML = `
            <tr>
                <td
                    colspan="6"
                    class="empty-cart"
                >
                    Keranjang masih kosong.
                    <br>
                    Silakan cari barang.
                </td>
            </tr>
        `;

        calculateTotal();

        return;
    }


    body.innerHTML =
        cart.map((item, index) => {

            return `
                <tr>

                    <td>
                        ${index + 1}
                    </td>

                    <td>

                        <strong>
                            ${item.name}
                        </strong>

                    </td>

                    <td>
                        ${formatRupiah(item.price)}
                    </td>

                    <td>

                        <div class="qty-control">

                            <button
                                type="button"
                                onclick="changeQty(
                                    ${item.id},
                                    -1
                                )"
                            >
                                −
                            </button>

                            <input
                                type="number"
                                value="${item.qty}"
                                min="1"
                                max="${item.stock}"
                                onchange="updateQty(
                                    ${item.id},
                                    this.value
                                )"
                            >

                            <button
                                type="button"
                                onclick="changeQty(
                                    ${item.id},
                                    1
                                )"
                            >
                                +
                            </button>

                        </div>

                    </td>

                    <td>
                        <strong>
                            ${
                                formatRupiah(
                                    item.price *
                                    item.qty
                                )
                            }
                        </strong>
                    </td>

                    <td>

                        <button
                            type="button"
                            class="remove-btn"
                            onclick="removeItem(
                                ${item.id}
                            )"
                        >
                            ×
                        </button>

                    </td>

                </tr>
            `;

        }).join('');


    calculateTotal();
}


/*
|--------------------------------------------------------------------------
| CHANGE QTY
|--------------------------------------------------------------------------
*/

function changeQty(id, amount)
{
    const item =
        cart.find(
            item => item.id == id
        );


    if (!item)
    {
        return;
    }


    const newQty =
        item.qty + amount;


    if (newQty <= 0)
    {
        removeItem(id);
        return;
    }


    if (newQty > item.stock)
    {
        alert('Jumlah melebihi stok.');
        return;
    }


    item.qty = newQty;

    renderCart();
}


/*
|--------------------------------------------------------------------------
| UPDATE QTY
|--------------------------------------------------------------------------
*/

function updateQty(id, qty)
{
    const item =
        cart.find(
            item => item.id == id
        );


    if (!item)
    {
        return;
    }


    qty = parseInt(qty) || 1;


    if (qty > item.stock)
    {
        qty = item.stock;

        alert('Jumlah disesuaikan dengan stok.');
    }


    item.qty =
        Math.max(1, qty);


    renderCart();
}


/*
|--------------------------------------------------------------------------
| REMOVE ITEM
|--------------------------------------------------------------------------
*/

function removeItem(id)
{
    cart =
        cart.filter(
            item => item.id != id
        );

    renderCart();
}


/*
|--------------------------------------------------------------------------
| CALCULATE TOTAL
|--------------------------------------------------------------------------
*/

function calculateTotal()
{
    let totalQty = 0;

    let subtotal = 0;


    cart.forEach(item => {

        totalQty += item.qty;

        subtotal +=
            item.price * item.qty;

    });


    const discountPercent =
        parseFloat(
            document.getElementById(
                'discountPercent'
            ).value
        ) || 0;


    const manualDiscount =
        parseFloat(
            document.getElementById(
                'discountAmount'
            ).value
        ) || 0;


    const tax =
        parseFloat(
            document.getElementById(
                'tax'
            ).value
        ) || 0;


    const otherFee =
        parseFloat(
            document.getElementById(
                'otherFee'
            ).value
        ) || 0;


    const percentDiscount =
        subtotal *
        (discountPercent / 100);


    const totalDiscount =
        percentDiscount +
        manualDiscount;


    const grandTotal =
        Math.max(
            0,
            subtotal -
            totalDiscount +
            tax +
            otherFee
        );


    document.getElementById(
        'totalQty'
    ).innerText = totalQty;


    document.getElementById(
        'itemCount'
    ).innerText =
        totalQty + ' Item';


    document.getElementById(
        'subtotal'
    ).innerText =
        formatRupiah(subtotal);


    document.getElementById(
        'grandTotal'
    ).innerText =
        formatRupiah(grandTotal);


    calculateChange();
}


/*
|--------------------------------------------------------------------------
| GET GRAND TOTAL
|--------------------------------------------------------------------------
*/

function getGrandTotal()
{
    let subtotal = 0;


    cart.forEach(item => {

        subtotal +=
            item.price * item.qty;

    });


    const discountPercent =
        parseFloat(
            document.getElementById(
                'discountPercent'
            ).value
        ) || 0;


    const discountAmount =
        parseFloat(
            document.getElementById(
                'discountAmount'
            ).value
        ) || 0;


    const tax =
        parseFloat(
            document.getElementById(
                'tax'
            ).value
        ) || 0;


    const otherFee =
        parseFloat(
            document.getElementById(
                'otherFee'
            ).value
        ) || 0;


    const discount =
        (
            subtotal *
            discountPercent /
            100
        ) +
        discountAmount;


    return Math.max(
        0,
        subtotal -
        discount +
        tax +
        otherFee
    );
}


/*
|--------------------------------------------------------------------------
| CALCULATE CHANGE
|--------------------------------------------------------------------------
*/

function calculateChange()
{
    const total =
        getGrandTotal();


    const payment =
        parseFloat(
            document.getElementById(
                'payment'
            ).value
        ) || 0;


    const change =
        payment - total;


    const changeBox =
        document.getElementById(
            'changeBox'
        );


    const changeElement =
        document.getElementById(
            'change'
        );


    if (change >= 0)
    {
        changeBox.classList.remove(
            'short-payment'
        );

        changeElement.innerText =
            formatRupiah(change);

        document.querySelector(
            '.change-label'
        ).innerText =
            'KEMBALIAN';
    }
    else
    {
        changeBox.classList.add(
            'short-payment'
        );

        changeElement.innerText =
            formatRupiah(
                Math.abs(change)
            );

        document.querySelector(
            '.change-label'
        ).innerText =
            'UANG KURANG';
    }
}


/*
|--------------------------------------------------------------------------
| PAYMENT METHOD
|--------------------------------------------------------------------------
*/

function selectPayment(
    button,
    method
)
{
    document
        .querySelectorAll(
            '.payment-method button'
        )
        .forEach(btn => {

            btn.classList.remove(
                'active'
            );

        });


    button.classList.add(
        'active'
    );


    document.getElementById(
        'paymentMethod'
    ).value = method;
}


/*
|--------------------------------------------------------------------------
| QUICK PAYMENT
|--------------------------------------------------------------------------
*/

function quickPayment(amount)
{
    document.getElementById(
        'payment'
    ).value = amount;

    calculateChange();
}


/*
|--------------------------------------------------------------------------
| EXACT PAYMENT
|--------------------------------------------------------------------------
*/

function exactPayment()
{
    document.getElementById(
        'payment'
    ).value =
        getGrandTotal();

    calculateChange();
}


/*
|--------------------------------------------------------------------------
| HOLD TRANSACTION
|--------------------------------------------------------------------------
*/

function holdTransaction()
{
    if (cart.length === 0)
    {
        alert(
            'Tidak ada transaksi untuk ditahan.'
        );

        return;
    }


    alert(
        'Fitur tahan transaksi akan dikembangkan pada tahap berikutnya.'
    );
}


/*
|--------------------------------------------------------------------------
| CANCEL TRANSACTION
|--------------------------------------------------------------------------
*/

function cancelTransaction()
{
    if (
        !confirm(
            'Batalkan transaksi ini?'
        )
    )
    {
        return;
    }


    cart = [];


    document.getElementById(
        'payment'
    ).value = '';


    document.getElementById(
        'discountPercent'
    ).value = 0;


    document.getElementById(
        'discountAmount'
    ).value = 0;


    document.getElementById(
        'tax'
    ).value = 0;


    document.getElementById(
        'otherFee'
    ).value = 0;


    renderCart();
}


/*
|--------------------------------------------------------------------------
| PREPARE PAYMENT
|--------------------------------------------------------------------------
*/

function preparePayment()
{
    if (cart.length === 0)
    {
        alert(
            'Keranjang masih kosong.'
        );

        return false;
    }


    const total =
        getGrandTotal();


    const payment =
        parseFloat(
            document.getElementById(
                'payment'
            ).value
        ) || 0;


    if (payment < total)
    {
        alert(
            'Uang pembayaran masih kurang.'
        );

        return false;
    }


    document.getElementById(
        'discount'
    ).value =
        (
            (
                parseFloat(
                    document.getElementById(
                        'discountPercent'
                    ).value
                ) || 0
            ) *
            (
                cart.reduce(
                    (sum, item) =>
                        sum +
                        item.price *
                        item.qty,
                    0
                )
            ) /
            100
        ) +
        (
            parseFloat(
                document.getElementById(
                    'discountAmount'
                ).value
            ) || 0
        );


    document.getElementById(
        'taxInput'
    ).value =
        parseFloat(
            document.getElementById(
                'tax'
            ).value
        ) || 0;


    document.getElementById(
        'otherFeeInput'
    ).value =
        parseFloat(
            document.getElementById(
                'otherFee'
            ).value
        ) || 0;


    document.getElementById(
        'paidAmount'
    ).value =
        payment;


    const cartInputs =
        document.getElementById(
            'cartInputs'
        );


    cartInputs.innerHTML = '';


    cart.forEach(
        (item, index) => {

            cartInputs.insertAdjacentHTML(
                'beforeend',
                `
                    <input
                        type="hidden"
                        name="items[${index}][product_id]"
                        value="${item.id}"
                    >

                    <input
                        type="hidden"
                        name="items[${index}][qty]"
                        value="${item.qty}"
                    >
                `
            );

        }
    );


    return true;
}


/*
|--------------------------------------------------------------------------
| DATE
|--------------------------------------------------------------------------
*/

const currentDate =
    document.getElementById(
        'currentDate'
    );


if (currentDate)
{
    currentDate.innerText =
        new Date().toLocaleString(
            'id-ID'
        );
}


/*
|--------------------------------------------------------------------------
| KEYBOARD SHORTCUT
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'keydown',
    function(event)
    {
        if (event.key === 'F2')
        {
            event.preventDefault();

            searchInput.focus();
        }


        if (event.key === 'F4')
        {
            event.preventDefault();

            document.getElementById(
                'payment'
            ).focus();
        }


        if (
            event.key === 'Escape'
        )
        {
            cancelTransaction();
        }
    }
);


/*
|--------------------------------------------------------------------------
| INITIAL
|--------------------------------------------------------------------------
*/

renderCart();