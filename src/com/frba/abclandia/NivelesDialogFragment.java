package com.frba.abclandia;

import com.frba.abclandia.utils.Util;
import com.google.gson.internal.ObjectConstructor;

import android.app.DialogFragment;
import android.graphics.Color;
import android.graphics.drawable.GradientDrawable;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.widget.Button;

public class NivelesDialogFragment extends DialogFragment implements View.OnClickListener {
	
	private Button btnNivel1, btnNivel2, btnNivel3;
	
	  public interface DialogLevelListener {
	        void onChooseLevel(int levelNumber);
	    }
	
	public NivelesDialogFragment(){
		
	}
	
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState) {
//    	Dialog.Window.RequestFeature(WindowFeatures.NoTitle);
    	getDialog().getWindow().requestFeature(Window.FEATURE_NO_TITLE);
        View view = inflater.inflate(R.layout.niveles_fragment, container);
        
        btnNivel1 = (Button) view.findViewById(R.id.btnNivel1);
        btnNivel1.setOnClickListener(this);
        GradientDrawable gd1 = (GradientDrawable) btnNivel1.getBackground();
        gd1.setColor(Color.parseColor("#F98F7D"));
      
      btnNivel2 = (Button) view.findViewById(R.id.btnNivel2);
      btnNivel2.setOnClickListener(this);
      GradientDrawable gd2 = (GradientDrawable) btnNivel2.getBackground();
      gd2.setColor(Color.parseColor("#F76D63"));
      
      btnNivel3 = (Button) view.findViewById(R.id.btnNivel3);
      btnNivel3.setOnClickListener(this);
      GradientDrawable gd3 = (GradientDrawable) btnNivel3.getBackground();
      gd3.setColor(Color.parseColor("#F25955"));
    
//        mEditText = (EditTe;xt) view.findViewById(R.id.txt_your_name);
//        getDialog().setTitle("Hello");

        return view;
    }
    
    @Override
    public void onStart()
    {
      super.onStart();

      // safety check
      if (getDialog() == null)
        return;

      int dialogWidth =Util.getTextSizeDensityDependent(getActivity(),680 );
      int dialogHeight =Util.getTextSizeDensityDependent(getActivity(), 400);; 

      getDialog().getWindow().setLayout(dialogWidth, dialogHeight);

    
    }

	@Override
	public void onClick(View v) {
		int level=1;
		if (v == btnNivel1)
			level = 1;
		else if (v == btnNivel2)
			level = 2;
		else 
			level = 3;
		
		((DialogLevelListener) getActivity()).onChooseLevel(level);
		
	}

}
