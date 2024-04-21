Introduction
BoolBnB is a web app that allows users to find and manage apartment rentals.

Apartment owners, by registering on BoolBnB, can enter their property information and decide whether to sponsor their listings to highlight them in searches and on the homepage.

Interested users can search for and view apartments without registering. Once they choose an apartment of interest, they can send a message to the owner through the platform to ask for more details.

User Types
We define the following types of users who can use BoolBnB:
Registered User (UR): a user who has completed registration
Registered User with Apartment (URA): a user who has registered and has entered at least one apartment into the system
Interested User (UI): any site user who is not registered

List of Pages

Homepage:

Offers the ability to search for apartments.
Also provides quick access to the detailed pages of featured apartments.
Advanced Search Page:
Allows viewing of search results, each result providing access to the apartment's detail page.
Also allows refining the search without refreshing the page by applying filters.
Public Apartment Detail Page:
Allows viewing all available details for an apartment and enables sending a message to the owner.
Registered User Dashboard:
Allows the insertion of a new apartment and access to one's own apartments.
Apartment List Page:
From here it is possible to access editing and deletion of one's own apartments, and access to related messages and statistics.
Single Apartment Message List Page
Single Apartment Statistics Page:
Allows viewing the statistics of the selected apartment.
Specifically, the graphs will show the number of views and the number of messages related to the apartment by months/years.
Sponsorship Page:
Through this panel, it is possible to sponsor a single apartment at a time, selecting the desired type of promotion and entering credit card details.
Technical Requirements
(RT1) Client-side Validation:

All user-entered inputs are checked client-side (as well as server-side) for accuracy (e.g., the number of rooms must be positive).
(RT2) Saving Geographic Information:
Data regarding the location of the apartments are saved in the database with latitude and longitude.
To obtain latitude and longitude from an address and likewise display the point on the map, TomTom is used: https://developer.tomtom.com/
(RT3) Payment System:
The payment system used is Braintree: https://www.braintreepayments.com/
The system allows developers to simulate payments without being formally approved and without using real credit cards.
(RT4) The site is responsive:
thus properly visible from desktop and smartphone
(RT5) The search for apartments on the dedicated page and the application of filters occur without page refresh.
Functional Requirements
The platform meets the following functional requirements (RF) detailed on the following pages:

(RF1) Allow apartment owners to register on the platform
Visibility: UI
Description:

The application allows apartment owners to register on the platform and create a profile.
The information that the user can enter includes:
Email *
Password *
First Name
Last Name
Date of Birth
Mandatory data marked with *.
Email and password are used by the user to log in to the platform.
There is no panel for modifying the information once registered.
Forms must comply with RT1.
Outcome: A new user is created in the system.
Exceptions: There is already a user in the system with the entered email.
(RF2) Allow registered apartment owners to add an apartment to the platform
Visibility: UR / URA
Description: A registered owner has the opportunity to enter one or more apartments into the system.

To add a new apartment, the owner must enter the following information:
Summary title describing the apartment
Number of rooms
Number of beds
Number of bathrooms
Square meters
Complete address (with latitude and longitude)
Representative image of the apartment
One or more additional services:
WiFi, Parking Spot, Pool, Concierge, Sauna, Sea View, etc.
Visible yes/no
It is possible to modify the information entered.
Forms must comply with RT1.
Entering the address leads to the saving of latitude and longitude in the database as described in RT2.
Outcome: A room is entered into the system and its information is updated.
Exceptions: /
(RF3) Allow visitors to search for an apartment
Visibility: UI / UR / URA
Description: Any user is able to search for an apartment within the database.

By entering an address, the system searches within the database for apartments within a 20 km radius from the indicated latitude and longitude.
Furthermore, it is possible to further refine the search by setting one or more of the following filters:
Minimum number of rooms
Minimum number of beds
Adjust the default range of 20km
The mandatory presence of one or more of the additional services indicated in RF2
The results are sorted by distance from the entered latitude/longitude.
The search complies with the requirement RT5.
Outcome: A list of apartments matching the search is generated, showing some details of the room.
Exceptions: /
(RF4) Allow visitors to see the details of an apartment
Visibility: UI / UR / URA
Description: By selecting an apartment from the appropriate panel, all available details concerning the room are displayed, as specified in RF2.

In particular, a map indicating the location of the apartment is shown.
Outcome: The detail page of an apartment is displayed.
Exceptions: /
(RF5) Allow visitors to write to the owner of an apartment to ask for information
Visibility: UI / UR / URA
Description: On the apartment detail page, it must be possible to send a message to the apartment owner.

The user must enter their email and a message.
If the user is a registered UR or URA, the email is auto-filled with the one entered during registration.
Outcome: The message is saved in the database.
Exceptions: /
(RF6) Allow registered apartment owners to see messages received
Visibility: URA
Description: An owner who has entered one or more apartments has the opportunity to see the inquiry messages received from users for the apartments.

There is no possibility for the user URA to respond from within the platform (they will respond directly via email outside the platform).
Outcome:
Exceptions: /
(RF7) Allow registered apartment owners to see statistics of their apartments
Visibility: URA
Description: An owner who has entered one or more apartments has the opportunity to see the viewing statistics for each apartment entered.
Outcome: The user views the statistics of the selected apartment.
Exceptions: /

(RF8) Allow registered apartment owners to sponsor their apartment
Visibility: URA
Description: An owner who has entered one or more apartments has the opportunity to pay to highlight them on the homepage and in the search page.

By entering a specific panel of their personal section, the URA user can select one of their apartments and choose one of the following promotional packages:
€2.99 for 24 hours of sponsorship
€5.99 for 72 hours of sponsorship
€9.99 for 144 hours of sponsorship
Payment is made via credit card following RT3.
A sponsored apartment has the following peculiarities:
Appears on the Homepage in the "Featured Apartments" section
In the search page, it is always positioned before a non-sponsored apartment that meets the same search characteristics.
Once the sponsorship period is over, the apartment will return to being displayed normally, without any peculiarities.
Outcome: The apartment is sponsored.
Exceptions: The payment system did not properly process the payment / credit card details are not valid.
