create
   trigger tr_atualiza_ultimo_andamento after insert
       or update
           on
           sw_andamento for each row execute procedure public.fn_atualiza_ultimo_andamento();


create
   trigger tr_exclui_ultimo_andamento before delete
       on
       sw_andamento for each row execute procedure public.fn_exclui_ultimo_andamento();