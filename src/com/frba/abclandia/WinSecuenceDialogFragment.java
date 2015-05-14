package com.frba.abclandia;

import android.app.DialogFragment;
import android.graphics.Color;
import android.graphics.drawable.GradientDrawable;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.widget.Button;

import com.frba.abclandia.utils.Util;

public class WinSecuenceDialogFragment extends DialogFragment implements View.OnClickListener {
	
	private Button btnPlayAgain,btnPlayNext;
	
	  public interface DialogWinSecuenceListener {
	        void onChooseOption(int levelNumber);
	    }
	
	public WinSecuenceDialogFragment(){
		
	}
	
  @Override
  public View onCreateView(LayoutInflater inflater, ViewGroup container,
          Bundle savedInstanceState) {
//  	Dialog.Window.RequestFeature(WindowFeatures.NoTitle);
	  getDialog().getWindow().requestFeature(Window.FEATURE_NO_TITLE);
      View view = inflater.inflate(R.layout.secuence_win_fragment, container);
      
      btnPlayAgain = (Button) view.findViewById(R.id.btnPlayAgain);
      btnPlayAgain.setOnClickListener(this);
      GradientDrawable gd1 = (GradientDrawable) btnPlayAgain.getBackground();
      gd1.setColor(Color.parseColor("#656D78"));
      
      btnPlayNext = (Button) view.findViewById(R.id.btnPlayNext);
      btnPlayNext.setOnClickListener(this);
      GradientDrawable gd2 = (GradientDrawable) btnPlayNext.getBackground();
      gd2.setColor(Color.parseColor("#656D78"));
      
     
      
      
  

      return view;
  }
  
  @Override
  public void onStart(){
     super.onStart();

    // safety check
    if (getDialog() == null)
      return;

    int dialogWidth =Util.getTextSizeDensityDependent(getActivity(), 670);
    int dialogHeight =Util.getTextSizeDensityDependent(getActivity(), 400);; 

    getDialog().getWindow().setLayout(dialogWidth, dialogHeight);

  }

	@Override
	public void onClick(View v) {
		int option=1;
		if (v == btnPlayNext)
			option = 2;
		
		
		((DialogWinSecuenceListener) getActivity()).onChooseOption(option);
		
		
		
		
		
	}

}
