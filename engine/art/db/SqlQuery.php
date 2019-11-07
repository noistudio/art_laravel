<?php

namespace db;

use core\Helper;

class SqlQuery {

    public static function insert($array, $name_table) {
        $last_id = \DB::table($name_table)->insertGetId(
                $array
        );

//        if ($name_table=="name_of_table" ) {
//            $update=array('sort_video'=>$last_id);
//            $primarykey=SqlModel::getPrimaryKey($name_table);
//            SqlQuery::update($name_table, $update, $primarykey."=".$last_id);
//        }
        \cache\models\Model::removeAll();
        return $last_id;
    }

    static function order_array_to_raw($orderby) {
        if (count($orderby) == 1) {
            foreach ($orderby as $key => $val) {
                return $key . " " . $val;
            }
        }
    }

    static function array_to_raw($condition, $not_finish = false, $return_array = true) {
        $use_vars = array();


        if (isset($condition) and is_array($condition) and count($condition) > 1) {
            $operator = $condition[0];
            if (isset($condition[1]) and is_array($condition[1])) {
                $raw_conditions = array();
                $i = 1;
                while (isset($condition[$i])) {

                    $tmp_result = SqlQuery::array_to_raw($condition[$i], true, $return_array);

                    foreach ($tmp_result['vars'] as $key => $var) {
                        if (isset($use_vars[$key])) {
                            foreach ($var as $subkey => $subval) {
                                $oldkey = ":" . $key . "_" . $subkey;
                                $use_vars[$key][] = $subval;
                                $next_id = count($use_vars[$key]) - 1;
                                $newkey = ":" . $key . "_" . $next_id;
                                $tmp_result['raw'] = str_replace($oldkey, $newkey, $tmp_result['raw']);
                            }
                        } else {
                            $use_vars[$key] = $var;
                        }
                    }
                    $raw_conditions[] = $tmp_result['raw'];

                    $i++;
                }




                if (count($raw_conditions) > 1) {

                    $result = array();
                    $result['raw'] = implode(" " . $operator . " ", $raw_conditions);
                    $result['vars'] = $use_vars;
                    if ($not_finish == false) {
                        if (count($result['vars']) > 0) {
                            $new_vars = array();
                            foreach ($result['vars'] as $key => $arr) {
                                if (count($arr)) {
                                    foreach ($arr as $subkey => $subval) {
                                        $new_vars[$key . "_" . $subkey] = $subval;
                                    }
                                }
                            }
                            $result['vars'] = $new_vars;

                            if ($return_array == false) {
                                $raw_string = $result['raw'];
                                foreach ($result['vars'] as $subkey => $subval) {
                                    $raw_string = str_replace(":" . $subkey, "'" . $subval . "'", $raw_string);
                                }

                                $result = $raw_string;
                            }
                        }
                    }

                    return $result;
                } else {
                    $result = array();
                    $result['raw'] = $raw_conditions[0];
                    $result['vars'] = $use_vars;
                    if ($not_finish == false) {
                        if (count($result['vars']) > 0) {
                            $new_vars = array();
                            foreach ($result['vars'] as $key => $arr) {
                                if (count($arr)) {
                                    foreach ($arr as $subkey => $subval) {
                                        $new_vars[$key . "_" . $subkey] = $subval;
                                    }
                                }
                            }
                            $result['vars'] = $new_vars;
                        }

                        if ($return_array == false) {
                            $raw_string = $result['raw'];
                            foreach ($result['vars'] as $subkey => $subval) {
                                $raw_string = str_replace(":" . $subkey, "'" . $subval . "'", $raw_string);
                            }

                            $result = $raw_string;
                        }
                    }
                    return $result;
                }
            } else if (count($condition) == 3) {
                $name_var = strtolower($condition[1]);
                $name_var = str_replace(".", "_", $name_var);
                if (!isset($use_vars[$name_var])) {
                    $use_vars[$name_var] = array();
                }

                $use_vars[$name_var][] = $condition[2];
                $next_id = count($use_vars[$name_var]) - 1;
                $name_var = $name_var . "_" . $next_id;


                $raw_sql = $condition[1] . " " . $condition[0] . ":" . $name_var;
                $result = array();
                $result['raw'] = $raw_sql;
                $result['vars'] = $use_vars;

                if ($not_finish == false) {
                    if (count($result['vars']) > 0) {
                        $new_vars = array();
                        foreach ($result['vars'] as $key => $arr) {
                            if (count($arr)) {
                                foreach ($arr as $subkey => $subval) {
                                    $new_vars[$key . "_" . $subkey] = $subval;
                                }
                            }
                        }
                        $result['vars'] = $new_vars;

                        if ($return_array == false) {
                            $raw_string = $result['raw'];
                            foreach ($result['vars'] as $subkey => $subval) {
                                $raw_string = str_replace(":" . $subkey, "'" . $subval . "'", $raw_string);
                            }

                            $result = $raw_string;
                        }
                    }
                }
                return $result;
            }
        } else {


            if (count($condition) == 2) {
                $name_var = strtolower($condition[0]);
                $name_var = str_replace(".", "_", $name_var);
                if (!isset($use_vars[$name_var])) {
                    $use_vars[$name_var] = array();
                }

                $use_vars[strtolower($name_var)][] = $condition[1];
                $next_id = count($use_vars[$name_var]) - 1;
                $name_var = $name_var . "_" . $next_id;
                $result = array();
                $result['raw'] = $condition[0] . " = :" . $name_var;
                $result['vars'] = $use_vars;

                if ($not_finish == false) {
                    if (count($result['vars']) > 0) {
                        $new_vars = array();
                        foreach ($result['vars'] as $key => $arr) {
                            if (count($arr)) {
                                foreach ($arr as $subkey => $subval) {
                                    $new_vars[$key . "_" . $subkey] = $subval;
                                }
                            }
                        }
                        $result['vars'] = $new_vars;

                        if ($return_array == false) {
                            $raw_string = $result['raw'];
                            foreach ($result['vars'] as $subkey => $subval) {
                                $raw_string = str_replace(":" . $subkey, "'" . $subval . "'", $raw_string);
                            }

                            $result = $raw_string;
                        }
                    }
                }
                return $result;
            } else if (count($condition) == 1) {

                foreach ($condition as $key => $value) {
                    $name_var = strtolower($key);
                    $name_var = str_replace(".", "_", $name_var);

                    if (!isset($use_vars[strtolower($name_var)])) {
                        $use_vars[strtolower($name_var)] = array();
                    }

                    $use_vars[strtolower($name_var)][] = $value;
                    $next_id = count($use_vars[$name_var]) - 1;
                    $name_var = $name_var . "_" . $next_id;
                    $result = array();
                    $result['raw'] = $key . " = :" . $name_var;
                    $result['vars'] = $use_vars;

                    if ($not_finish == false) {
                        if (count($result['vars']) > 0) {
                            $new_vars = array();
                            foreach ($result['vars'] as $key => $arr) {
                                if (count($arr)) {
                                    foreach ($arr as $subkey => $subval) {
                                        $new_vars[$key . "_" . $subkey] = $subval;
                                    }
                                }
                            }
                            $result['vars'] = $new_vars;

                            if ($return_array == false) {
                                $raw_string = $result['raw'];
                                foreach ($result['vars'] as $subkey => $subval) {
                                    $raw_string = str_replace(":" . $subkey, "'" . $subval . "'", $raw_string);
                                }

                                $result = $raw_string;
                            }
                        }
                    }

                    return $result;
                }
            } else {

                $name_var = strtolower($condition[0]);
                $name_var = str_replace(".", "_", $name_var);
                if (!isset($use_vars[$name_var])) {
                    $use_vars[$name_var] = array();
                }

                $use_vars[$name_var][] = $condition[2];
                $next_id = count($use_vars[$name_var]) - 1;
                $name_var = $name_var . "_" . $next_id;
                $result = array();
                $result['raw'] = $condition[1] . " " . $condition[0] . " : " . $name_var;
                $result['vars'] = $use_vars;

                if ($not_finish == false) {
                    if (count($result['vars']) > 0) {
                        $new_vars = array();
                        foreach ($result['vars'] as $key => $arr) {
                            if (count($arr)) {
                                foreach ($arr as $subkey => $subval) {
                                    $new_vars[$key . "_" . $subkey] = $subval;
                                }
                            }
                        }
                        $result['vars'] = $new_vars;

                        if ($return_array == false) {
                            $raw_string = $result['raw'];
                            foreach ($result['vars'] as $subkey => $subval) {
                                $raw_string = str_replace(":" . $subkey, "'" . $subval . "'", $raw_string);
                            }

                            $result = $raw_string;
                        }
                    }
                }

                return $result;
            }
        }
        return null;
    }

    static function count($condition, $nametable) {
        $query = \DB::table($nametable);
        if (isset($condition) and ! is_null($condition)) {
            if (isset($condition) and is_string($condition)) {
                $query->whereRaw($condition);
            } else {
                $query->whereRaw($condition['raw'], $condition['vars']);
            }
        }

        return $query->count();
    }

    static function get($condition, $nametable) {

        $query = \DB::table($nametable);
        if (isset($condition)) {
            if (is_array($condition) and isset($condition['raw']) and isset($condition['vars'])) {
                $query->whereRaw($condition['raw'], $condition['vars']);
            } else {
                $query->where($condition);
            }
        }

        $result = $query->first();
        $result = Helper::toArray($result);
        return $result;
    }

    static function all($condition, $nametable, $orderby = array('name', 'desk')) {
        $default = array('name', 'desk');
        $query = \DB::table($nametable);
        if (isset($condition) and ! is_null($condition)) {
            if (isset($condition) and is_string($condition)) {
                $query->whereRaw($condition);
            } else {
                $query->whereRaw($condition['raw'], $condition['vars']);
            }
        }

        if (is_array($orderby) and $orderby != $default) {
            $query->orderBy($orderby[0], $orderby[1]);
        }

        $result = $query->get();
        $result = Helper::toArray($result);
        return $result;
    }

    public static function update($nametable, $update, $condition) {

        if (isset($condition) and is_array($condition) and isset($condition['raw']) and isset($condition['vars'])) {

            $affected = \DB::table($nametable)->whereRaw($condition['raw'], $condition['vars'])->update($update);
        } else if (is_string($condition)) {
            $affected = \DB::table($nametable)
                    ->whereRaw($condition)
                    ->update($update);
        } else {
            $affected = \DB::table($nametable)
                    ->where($condition)
                    ->update($update);
        }
        return $affected;
    }

    public static function delete($name_table, $condition) {
        if (isset($condition) and is_array($condition) and isset($condition['raw']) and isset($condition['vars'])) {
            \DB::table($name_table)->where($condition['raw'], $condition['vars'])->delete();
        } else if (is_string($condition)) {
            \DB::table($name_table)->whereRaw($condition)->delete();
        } else if (!is_null($condition)) {
            \DB::table($name_table)->where($condition)->delete();
        }




        \cache\models\Model::removeAll();
    }

}
