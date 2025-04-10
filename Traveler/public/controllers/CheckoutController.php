<?php

namespace controllers;

use core\Controller;
use core\Core;
use core\Utils;
use models\Booking;
use models\Room;
use models\Tour;
use models\User;

class CheckoutController extends Controller
{
    function newAction($params)
    {
        $bookedTour = Tour::getTourById($_GET['tour_id']);
        $bookedRooms = [];

        $totalPrice = 0;
        foreach ($_GET['room_id'] as $i => $room_id) {
            $room = Room::getRoomById($room_id);

            $price = intval($_GET['room_count'][$i]) * intval($_GET['days']) * $room['price'];
            $totalPrice += $price;
            $bookedRooms[] = [
                ...$room,
                'booked_count' => $_GET['room_count'][$i],
                'cost' => Utils::formatedPrice($price),
                'str_price' => Utils::formatedPrice($room['price']),
                'int_price' => $price
            ];
        }

        $date_int = strtotime($_GET['date']);
        $check_in = Utils::fullDate($date_int);

        $cancelBeforeDate = date("d.m.Y",$date_int - 24 * 60 * 60);

        $date_int += intval($_GET['days']) * 24 * 60 * 60;
        $check_out = Utils::fullDate($date_int);

        $tourists = Utils::trueFormatedTourists($_GET['tourists']);

        if (Core::getInstance()->requestMethod == "POST") {
            $tour_id = $bookedTour['tour_id'];
            $user_id = User::isLogUser()? User::getCurrentUser()['id'] : null;
            $date = date("Y-m-d",$date_int);
            $days = intval($_GET['days']);
            $tourists = intval($_GET['tourists']);
            $full_name = $_POST['full_name'];
            $phone_number = $_POST['phone_number'];
            $total_price = $totalPrice;
            $status = 0;

            $rooms = [];
            foreach ($bookedRooms as $bookedRoom) {
                $rooms[] = [
                    'room_id' => $bookedRoom['room_id'],
                    'count' => $bookedRoom['booked_count'],
                    'price' => $bookedRoom['price'],
                ];
            }

            Booking::addBooking($tour_id, $user_id, $date, $days, $tourists,
                $full_name, $phone_number, $total_price, $status, $rooms);

            $this->message("Заявку успішно оформлено", "positive");
            $this->redirect("/tours");
        }

        return $this->render(path: "views/tours/checkout/index.php", params: [
            'header_page' => 'tours',
            'bookedTour' => $bookedTour,
            'bookedRooms' => $bookedRooms,
            'bookingDetails' => [
                'check_in' => $check_in,
                'check_out' => $check_out,
                'tourists' => $tourists,
                'cancel_before_date' => $cancelBeforeDate,
                'total_price' => Utils::formatedPrice($totalPrice),
            ],
        ]);
    }

    function viewAction($params)
    {
        $booking_id = $params[0];
        $user_id = User::getCurrentUser()['id'] ?? 0;
        $isUsersBooking = Booking::isUsersBooking($booking_id, $user_id);

        if ($isUsersBooking || User::isCurrentUserModerator()) {
            $booking = Booking::getCheckout($booking_id);
            $bookedTour = Tour::getTourById($booking['tour_id']);


            $totalPrice = 0;
            $bookedRooms = [];
            foreach ($booking['rooms'] as $i => $booked_room) {
                $room = Room::getRoomById($booked_room['room_id']);

                $full_price = intval($booked_room['count']) * intval($booking['days']) * $booked_room['price'];
                $totalPrice += $full_price;
                $bookedRooms[] = [
                    ...$room,
                    'booked_count' => $booked_room['count'],
                    'cost' => Utils::formatedPrice($full_price),
                    'str_price' => Utils::formatedPrice($booked_room['price']),
                    'int_price' => $full_price
                ];
            }

            $date_int = strtotime($booking['date']);
            $check_in = Utils::fullDate($date_int);

            $cancelBeforeDate = date("d.m.Y",$date_int - 24 * 60 * 60);

            $date_int += intval($booking['days']) * 24 * 60 * 60;
            $check_out = Utils::fullDate($date_int);

            $tourists = Utils::trueFormatedTourists($booking['tourists']);

            $booking_id = $booking['booking_id'];
            $full_name = $booking['full_name'];
            $phone_number = $booking['phone_number'];
            $user = User::getUserById($booking['user_id'] ?? null);
            $status = $booking['status'];

            return $this->render(path: "views/tours/checkout/index.php", params: [
                'header_page' => 'tours',
                'bookedTour' => $bookedTour,
                'bookedRooms' => $bookedRooms,
                'bookingDetails' => [
                    'check_in' => $check_in,
                    'check_out' => $check_out,
                    'tourists' => $tourists,
                    'cancel_before_date' => $cancelBeforeDate,
                    'total_price' => Utils::formatedPrice($totalPrice),
                ],
                'userInfo' => [
                    'booking_id' => $booking_id,
                    'full_name' => $full_name,
                    'phone_number' => $phone_number,
                    'user' => $user,
                    'status' => $status
                ]
            ]);
        }
        return $this->error(404);
    }

    function change_statusAction()
    {
        if (User::isCurrentUserModerator() && Core::getInstance()->requestMethod == "POST")
        {
            $booking_id = $_POST['booking_id'];
            $status = $_POST['status'];

            Booking::changeStatus($booking_id, $status);
            $this->message("Статус заявки на бронювання змінено", "neutral");
            die;
        } else
            $this->error(404);
    }

    function deleteAction()
    {

        if (Core::getInstance()->requestMethod == "POST")
        {
            $booking_id = $_POST['booking_id'];
            $user_id = User::getCurrentUser()['id'] ?? 0;
            $isUsersBooking = Booking::isUsersBooking($booking_id, $user_id);

            if ($isUsersBooking || User::isCurrentUserModerator()) {
                Booking::deleteBooking($booking_id);
                $this->message("Заявку на бронювання відмінено", "neutral");
                die;
            }
        }
        return $this->error(404);
    }
}