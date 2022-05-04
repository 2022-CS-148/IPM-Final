<?php
/*
require 'vendor/autoload.php';

use Square\SquareClient;
use Square\Environment;
use Square\Exceptions\ApiException;

$client = new SquareClient([
    'accessToken' => getenv('EAAAEMDQDZak7sE-gGfEUx8XmY7yqvG0lcA2QBewSqHZRNuqDUUcsClQHNWqrgCd'),
    'environment' => Environment::SANDBOX,
]);

try {

    $apiResponse = $client->getLocationsApi()->listLocations();

    if ($apiResponse->isSuccess()) {
        $result = $apiResponse->getResult();
        foreach ($result->getLocations() as $location) {
            printf(
                "%s: %s, %s, %s<p/>",
                $location->getId(),
                $location->getName(),
                $location->getAddress()->getAddressLine1(),
                $location->getAddress()->getLocality()
            );
        }

    } else {
        $errors = $apiResponse->getErrors();
        foreach ($errors as $error) {
            printf(
                "%s<br/> %s<br/> %s<p/>",
                $error->getCategory(),
                $error->getCode(),
                $error->getDetail()
            );
        }
    }

} catch (ApiException $e) {
    echo "ApiException occurred: <b/>";
    echo $e->getMessage() . "<p/>";
}
*/
?>

<!DOCTYPE html>
<html>
  <head>
    <link href="/app.css" rel="stylesheet" />
    <script
      type="text/javascript"
      src="https://sandbox.web.squarecdn.com/v1/square.js"
    ></script>
    <script>
      const appId = '{sandbox-sq0idb-VJ0u64Lfk4fWpYxu5P_6pg}';
      const locationId = '{L9ARQHGTNAH8D}';

      async function createPaymentWithCardOnFile(
        sourceId,
        customerId,
        verificationToken
      ) {
        const bodyParameters = {
          locationId,
          sourceId,
          customerId,
          verificationToken,
        };

        const body = JSON.stringify(bodyParameters);

        const paymentResponse = await fetch('/payment', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body,
        });

        if (paymentResponse.ok) {
          return paymentResponse.json();
        }

        const errorBody = await paymentResponse.text();
        throw new Error(errorBody);
      }

      // status is either SUCCESS or FAILURE;
      function displayPaymentResults(status) {
        const statusContainer = document.getElementById(
          'payment-status-container'
        );
        if (status === 'SUCCESS') {
          statusContainer.classList.remove('is-failure');
          statusContainer.classList.add('is-success');
        } else {
          statusContainer.classList.remove('is-success');
          statusContainer.classList.add('is-failure');
        }

        statusContainer.style.visibility = 'visible';
      }

      async function verifyBuyer(payments, sourceId) {
        const verificationDetails = {
          amount: '1.00',
          billingContact: {
            addressLines: ['123 Main Street', 'Apartment 1'],
            familyName: 'Doe',
            givenName: 'John',
            email: 'jondoe@gmail.com',
            country: 'GB',
            phone: '3214563987',
            region: 'LND',
            city: 'London',
          },
          currencyCode: 'GBP',
          intent: 'CHARGE',
        };

        const verificationResults = await payments.verifyBuyer(
          sourceId,
          verificationDetails
        );
        return verificationResults.token;
      }

      document.addEventListener('DOMContentLoaded', async function () {
        if (!window.Square) {
          throw new Error('Square.js failed to load properly');
        }

        let payments;
        try {
          payments = window.Square.payments(appId, locationId);
        } catch {
          const statusContainer = document.getElementById(
            'payment-status-container'
          );
          statusContainer.className = 'missing-credentials';
          statusContainer.style.visibility = 'visible';
          return;
        }

        async function handlePaymentWithCardOnFileMethodSubmission(
          event,
          cardId,
          customerId
        ) {
          event.preventDefault();

          try {
            // disable the submit button as we await tokenization and make a payment request.
            cardButton.disabled = true;

            let verificationToken = await verifyBuyer(payments, cardId);
            const paymentResults = await createPaymentWithCardOnFile(
              cardId,
              customerId,
              verificationToken
            );

            displayPaymentResults('SUCCESS');
            console.debug('Payment Success', paymentResults);
          } catch (e) {
            cardButton.disabled = false;
            displayPaymentResults('FAILURE');
            console.error(e.message);
          }
        }

        const cardButton = document.getElementById('card-button');
        cardButton.addEventListener('click', async function (event) {
          const customerTextInput = document.getElementById('customer-input');
          const cardTextInput = document.getElementById('card-input');

          if (
            !customerTextInput.reportValidity() ||
            !cardTextInput.reportValidity()
          ) {
            return;
          }

          const cardId = cardTextInput.value;
          const customerId = customerTextInput.value;
          handlePaymentWithCardOnFileMethodSubmission(
            event,
            cardId,
            customerId
          );
        });
      });
    </script>
  </head>
  <body>
    <form id="payment-form">
      <input
        id="customer-input"
        type="text"
        aria-required="true"
        aria-label="Customer ID"
        required="required"
        placeholder="Customer ID"
        name="customerId"
      />
      <input
        id="card-input"
        type="text"
        aria-required="true"
        aria-label="Card ID"
        required="required"
        placeholder="Card ID"
        name="cardId"
      />
      <button id="card-button" type="button">Pay $1.00</button>
    </form>
    <div id="payment-status-container"></div>
  </body>
</html>

