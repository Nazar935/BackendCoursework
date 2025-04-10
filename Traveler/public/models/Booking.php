<?php

namespace models;

use core\Core;
use core\Utils;

class Booking
{
    public static string $table = 'Booking';
    public static string $roomTable = 'BookingRoom';

    public static function getBookingArray()
    {
        $bookingArray = Core::getInstance()->db->select(self::$table, ["*"], [
            'status' => '0'
        ], order: "booking_id desc") ?? [];

        foreach ($bookingArray as $i => $booking)
            $bookingArray[$i] = self::processBooking($booking);

        return $bookingArray;
    }

    public static function getBookingHistory()
    {
        $bookingArray = Core::getInstance()->db->call("getBookingHistory", []) ?? [];

        foreach ($bookingArray as $i => $booking)
            $bookingArray[$i] = self::processBooking($booking);

        return $bookingArray;
    }

    public static function getBookingArrayForUser($user_id)
    {
        $bookingArray = Core::getInstance()->db->select(self::$table, ["*"], [
            'user_id' => $user_id
        ], order: "booking_id desc") ?? [];

        foreach ($bookingArray as $i => $booking)
            $bookingArray[$i] = self::processBooking($booking);

        return $bookingArray;
    }

    public static function roomBookingCount($room_id, $date)
    {
        return Core::getInstance()->db->call("isRoomBooked", [
            $room_id,
            $date
        ])[0]['available_rooms'];
    }

    public static function getCheckout($booking_id)
    {
        $booking = Core::getInstance()->db->select(self::$table, ["*"], [
            'booking_id' => $booking_id
        ])[0];

        return self::processBooking($booking);
    }

    public static function processBooking($booking)
    {
        $booking['tour'] = Tour::getTourById($booking["tour_id"]);
        $booking['user'] = User::getUserById($booking["user_id"]);
        $booking['check_in'] = Utils::fullDate(strtotime($booking['date']));
        $booking['days_str'] = Utils::formatedDays($booking['days']);
        $booking['tourists_str'] = Utils::trueFormatedTourists($booking['tourists']);

        $booking['rooms'] = Core::getInstance()->db->select(self::$roomTable, ["*"], [
            'booking_id' => $booking['booking_id']
        ]);

        return $booking;
    }

    public static function addBooking($tour_id, $user_id, $date, $days, $tourists,
                                       $full_name, $phone_number, $total_price, $status, $rooms)
    {
        Core::getInstance()->db->insert(static::$table, [
            'tour_id' => $tour_id,
            'user_id' => $user_id,
            'date' => $date,
            'days' => $days,
            'tourists' => $tourists,
            'full_name' => $full_name,
            'phone_number' => $phone_number,
            'total_price' => $total_price,
            'status' => $status
        ]);

        $booking_id = Core::getInstance()->db->select(self::$table, ['booking_id'], page_offset: 1, order: "booking_id desc")[0]['booking_id'];

        foreach ($rooms as $room)
            Core::getInstance()->db->insert(static::$roomTable, [
                'booking_id' => $booking_id,
                'room_id' => $room['room_id'],
                'count' => $room['count'],
                'price' => $room['price']
            ]);
    }

    public static function changeStatus($booking_id, $status)
    {
        Core::getInstance()->db->update(static::$table, [
            'status' => $status
        ], "booking_id", $booking_id);
    }

    public static function isUsersBooking($booking_id, $user_id)
    {
        return Core::getInstance()->db->select(self::$table, ["*"], [
            'booking_id' => $booking_id,
            'user_id' => $user_id
        ])[0] ?? false;
    }

    public static function deleteBooking($booking_id)
    {
        Core::getInstance()->db->delete(static::$table, "booking_id", $booking_id);
    }
}