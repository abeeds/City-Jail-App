# City-Jail-App
Final Schema statements: <br /> 
criminal(c_id, c_last, c_first, c_street, c_city, c_state, c_zip, c_phone_num, V_status, P_status) <br /> 
alias(alias_id, @c_id, alias) <br /> 
crime(case_id, @c_id, classification, date_charged, appeal_status, appeal_cutoff_date) <br /> 
prof_officer(p_id, p_last, p_first, p_street, p_city, p_state, p_zip, p_email, p_status) <br /> 
sentence(sentence_id, @c_id, @p_id, start_date, end_date, num_violations, type) <br /> 
officer(badge_number, o_last, o_first, o_precinct, o_phone_number, o_status) <br /> 
crime_officer(@badge_number, @case_id) <br /> 
crime_code(code_num, code_desc) <br /> 
charge(charge_id, @case_id, @code_num, charge_status, fine_amount, court_fee, amount_paid, payement_date) <br /> 
appeal(attempt_num, @case_id, filling_date, appeal_hearing_date, result_status) <br /> 


![Project_1_Milestone](https://user-images.githubusercontent.com/84909990/230780979-7adecf93-a58a-4179-9342-caf466d2635a.jpg)
