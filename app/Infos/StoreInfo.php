<?php

class StoreInfo {
    private $first_name, $last_name, $store_name, $phone_number, $password, $open_time
        , $close_time, $category, $store_description, $address, $address_latitude, $address_longitude, $cover_dir, $profile_dir;

    public function __construct($first_name, $last_name, $store_name, $phone_number, $password, $open_time
        , $close_time, $category, $store_description, $address, $address_latitude, $address_longitude, $cover_dir, $profile_dir)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->store_name = $store_name;
        $this->phone_number = $phone_number;
        $this->password = $password;
        $this->open_time = $open_time;
        $this->close_time = $close_time;
        $this->category = $category;
        $this->store_description = $store_description;
        $this->address = $address;
        $this->address_latitude = $address_latitude;
        $this->address_longitude = $address_longitude;
        $this->cover_dir = $cover_dir;
        $this->profile_dir = $profile_dir;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return mixed
     */
    public function getStoreName()
    {
        return $this->store_name;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getOpenTime()
    {
        return $this->open_time;
    }

    /**
     * @return mixed
     */
    public function getCloseTime()
    {
        return $this->close_time;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getStoreDescription()
    {
        return $this->store_description;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getAddressLatitude()
    {
        return $this->address_latitude;
    }

    /**
     * @return mixed
     */
    public function getAddressLongitude()
    {
        return $this->address_longitude;
    }

    /**
     * @return mixed
     */
    public function getCoverDir()
    {
        return $this->cover_dir;
    }

    /**
     * @return mixed
     */
    public function getProfileDir()
    {
        return $this->profile_dir;
    }


}