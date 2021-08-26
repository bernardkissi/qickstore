//TODO: Task 1 1/07/2021
Task 1 handle order process flow

// creating orders
// 1. sync items in cart with quantity
// 2. check if the the cart is not empty
// 3. get items from cart
// 4. create the order -- set the transition state to pending
// make payment of the order -- after the webhook response we set order to state of paid

//jobs behind the scene

// OnPaid
//1. Empty the cart of the user or visitior
//2. sent an SMS/Voice to the seller.
//3. Sent an email/SMS to the buyer with tracking code
//4. A delivery is made to the swoove delivery network -- create a delivery table to handle this with status

// OnFailed
// they buyer is alerted on failure of order
// we log the reason on failure on the order
// buyer can retry the order on a signed url with ttl set

//onDelivery
// We alert user everystep on the way
// From pickup to drop off
// we automatically close the order after 4 hours
// we send customer satisfaction order link to rate his order

// OnCompleted
// we send a satisfaction message for store rating // anyway we can improve our service
// And finally we dispatch the funds to the buyer.

// on refund
//create dispute with proof with images
// shop owner / super admins are notified
// The outcome of the dispute is
//send sms to the customer about the refund details

//TODO: Task 2 2/07/2021
//TODO: Task 3 3/07/2021
//TODO: Task 4 4/07/2021
//TODO: Task 5 3/07/2021

if swoove is used
// a delivery will be created and both customer and seller will be notified
if hosted delivery-
// a notification is sent to the seller alerting him to create a delivery for the purchase
if files delivery
// a download link is sent to your email or sms to download the resource paid for.

Unique jobs

Pending order ---- failed / Paid

1. empty cart ----- on Paid only

Order Paid ------- to shipped / delivered ---- Refunded

2. Sending of sms to seller
3. sending of sms to buyer 4. if swoove {
4. a delivery is created and the user is notifie  
   if hosted a notification is sent to the seller on the basis of delivery
   if files delivery - a download link will be sent to your email or sms to download the resource you have paid for.

Order Failure 5. We log the reason of failure 6. The order repayment is opened for n period 7. Buyer will be sent an email/sms with the repayment link

shipped ------ delievered ---- refunded
Shipped Order 8. buyer is alerted of the of his delivery through sms/ or email 9. We Listen to webhook events from swoove to update customer on every move

----- delivered
Order Delivered 10. Order is automatically close after 4 hours of delivery 11. A satisfaction link is sent to customer to rate his experience 12. And finally cash is dispatched to the appropriate channel

-----refunded
Order Refund Raised 13. A Message is sent to the seller ^ admin raising a dispute 14. Refund approval notice is sent to the customer
if necessary, Repayment is made to the customer or buyer

Why dont you cache the image content with apc ?

if(!apc*exists('img*'.$id)){
    apc_store('img_'.$id,file_get_content(...));
}

echo apc*fetch('img*'.$id);

this way image content will not be read from your disk more than once.

// if ($this->failed_at === null) {
        //     $filtered = $filtered->reject(fn ($value) => $value == 'failed');
// }

        // if ($this->cancelled_at === null) {
        //     $filtered = $filtered->reject(fn ($value) => $value == 'cancelled');
        // }


//TODO: inventory triggers
